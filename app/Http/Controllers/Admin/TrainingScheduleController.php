<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TrainingReminderMail;
use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TrainingScheduleController extends Controller
{
    /**
     * Daftar semua jadwal latihan
     */
    public function index(Request $request): View
    {
        $query = TrainingSchedule::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location_detail', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

        $schedules = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Statistik
        $totalSchedules = TrainingSchedule::count();
        $totalRutin     = TrainingSchedule::where('type', 'rutin')->count();
        $totalTambahan  = TrainingSchedule::where('type', 'tambahan')->count();
        $totalActive    = TrainingSchedule::where('is_active', true)->count();

        return view('admin.training-schedules.index', compact(
            'schedules',
            'totalSchedules',
            'totalRutin',
            'totalTambahan',
            'totalActive'
        ));
    }

    /**
     * Form tambah jadwal baru
     */
    public function create(): View
    {
        return view('admin.training-schedules.create');
    }

    /**
     * Simpan jadwal baru ke database
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSchedule($request);
        $validated['created_by'] = auth()->id();

        // Untuk latihan tambahan, days_of_week tidak diperlukan
        if ($validated['type'] === 'tambahan') {
            $validated['days_of_week'] = null;
        }

        // Untuk latihan rutin, specific_date tidak diperlukan
        if ($validated['type'] === 'rutin') {
            $validated['specific_date'] = null;
        }

        TrainingSchedule::create($validated);

        return redirect()->route('admin.training-schedules.index')
            ->with('success', 'Jadwal latihan berhasil ditambahkan!');
    }

    /**
     * Form edit jadwal
     */
    public function edit(TrainingSchedule $trainingSchedule): View
    {
        return view('admin.training-schedules.edit', compact('trainingSchedule'));
    }

    /**
     * Update jadwal di database
     */
    public function update(Request $request, TrainingSchedule $trainingSchedule): RedirectResponse
    {
        $validated = $this->validateSchedule($request, $trainingSchedule->id);

        if ($validated['type'] === 'tambahan') {
            $validated['days_of_week'] = null;
        }

        if ($validated['type'] === 'rutin') {
            $validated['specific_date'] = null;
        }

        $trainingSchedule->update($validated);

        return redirect()->route('admin.training-schedules.index')
            ->with('success', 'Jadwal latihan berhasil diperbarui!');
    }

    /**
     * Hapus jadwal
     */
    public function destroy(TrainingSchedule $trainingSchedule): RedirectResponse
    {
        $trainingSchedule->delete();

        return redirect()->route('admin.training-schedules.index')
            ->with('success', 'Jadwal latihan berhasil dihapus.');
    }

    /**
     * Tampilkan halaman kirim pengingat email untuk jadwal tertentu
     */
    public function showSendReminder(TrainingSchedule $trainingSchedule): View
    {
        // Daftar semua Senpai
        $senpaiList = User::whereHas('role', fn($q) => $q->where('nama', 'Senpai'))
            ->orderBy('name')
            ->get();

        // Daftar semua Kohai
        $kohaiList = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
            ->with('kohaiProfile.studyProgram.department')
            ->orderBy('name')
            ->get();

        return view('admin.training-schedules.send-reminder', compact(
            'trainingSchedule', 'senpaiList', 'kohaiList'
        ));
    }

    /**
     * Kirim email pengingat ke Senpai & Kohai yang dipilih
     */
    public function sendReminder(Request $request, TrainingSchedule $trainingSchedule): RedirectResponse
    {
        $request->validate([
            'send_to_senpai'  => 'nullable|in:all,selected,none',
            'senpai_ids'      => 'nullable|array',
            'senpai_ids.*'    => 'exists:users,id',
            'send_to_kohai'   => 'nullable|in:all,polindra,selected,none',
            'kohai_ids'       => 'nullable|array',
            'kohai_ids.*'     => 'exists:users,id',
        ]);

        $totalSent = 0;
        $failedEmails = [];

        // ── Kirim ke Senpai ──────────────────────────────────────────────────
        $sendToSenpai = $request->input('send_to_senpai', 'none');

        if ($sendToSenpai === 'all') {
            $senpais = User::whereHas('role', fn($q) => $q->where('nama', 'Senpai'))->get();
        } elseif ($sendToSenpai === 'selected' && $request->filled('senpai_ids')) {
            $senpais = User::whereIn('id', $request->input('senpai_ids'))
                ->whereHas('role', fn($q) => $q->where('nama', 'Senpai'))
                ->get();
        } else {
            $senpais = collect();
        }

        foreach ($senpais as $senpai) {
            try {
                Mail::to($senpai->email)->send(
                    new TrainingReminderMail($trainingSchedule, $senpai, 'senpai')
                );
                $totalSent++;
            } catch (\Throwable $e) {
                $failedEmails[] = $senpai->email;
                \Illuminate\Support\Facades\Log::error("Gagal kirim email reminder ke Senpai {$senpai->email}: " . $e->getMessage());
            }
        }

        // ── Kirim ke Kohai ───────────────────────────────────────────────────
        $sendToKohai = $request->input('send_to_kohai', 'none');

        if ($sendToKohai === 'all') {
            $kohais = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))->get();
        } elseif ($sendToKohai === 'polindra') {
            // Kohai yang profilnya Polindra
            $kohais = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
                ->where(function ($q) {
                    $q->whereHas('kohaiProfile', fn($qp) => $qp->where('type', 'polindra'))
                      ->orWhereHas('kohaiProfile.studyProgram');
                })
                ->get();
        } elseif ($sendToKohai === 'selected' && $request->filled('kohai_ids')) {
            $kohais = User::whereIn('id', $request->input('kohai_ids'))
                ->whereHas('role', fn($q) => $q->where('nama', 'Kohai'))
                ->get();
        } else {
            $kohais = collect();
        }

        foreach ($kohais as $kohai) {
            try {
                Mail::to($kohai->email)->send(
                    new TrainingReminderMail($trainingSchedule, $kohai, 'kohai')
                );
                $totalSent++;
            } catch (\Throwable $e) {
                $failedEmails[] = $kohai->email;
                \Illuminate\Support\Facades\Log::error("Gagal kirim email reminder ke Kohai {$kohai->email}: " . $e->getMessage());
            }
        }

        if ($totalSent === 0 && empty($failedEmails)) {
            return redirect()->route('admin.training-schedules.index')
                ->with('warning', 'Tidak ada penerima yang dipilih untuk pengiriman notifikasi email.');
        }

        $msg = "Email pengingat jadwal latihan berhasil dikirim ke {$totalSent} penerima!";
        if (!empty($failedEmails)) {
            $msg .= " (Catatan: " . count($failedEmails) . " alamat email gagal dihubungi server mail).";
        }

        return redirect()->route('admin.training-schedules.index')
            ->with('success', $msg);
    }

    /**
     * Toggle status aktif jadwal
     */
    public function toggleActive(TrainingSchedule $trainingSchedule): RedirectResponse
    {
        $trainingSchedule->update(['is_active' => ! $trainingSchedule->is_active]);
        $status = $trainingSchedule->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Jadwal latihan berhasil {$status}.");
    }

    /**
     * Validasi input jadwal (dipakai store & update)
     */
    private function validateSchedule(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'type'            => 'required|in:rutin,tambahan',
            'title'           => 'required|string|max:255',
            'start_time'      => 'required|date_format:H:i',
            'end_time'        => 'nullable|date_format:H:i|after:start_time',
            'days_of_week'    => 'required_if:type,rutin|array',
            'days_of_week.*'  => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_date'      => 'required|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'specific_date'   => 'required_if:type,tambahan|nullable|date',
            'location_type'   => 'required|in:polindra,luar_polindra',
            'location_detail' => 'nullable|string|max:255',
            'maps_url'        => 'nullable|url|max:500',
            'email_reminder'  => 'nullable|boolean',
            'reminder_time'   => 'nullable|in:pagi,malam',
            'notes'           => 'nullable|string|max:1000',
            'is_active'       => 'nullable|boolean',
        ], [
            'days_of_week.required_if' => 'Pilih minimal satu hari latihan untuk jadwal rutin.',
            'specific_date.required_if' => 'Tanggal spesifik wajib diisi untuk latihan tambahan.',
            'end_time.after'           => 'Jam selesai harus setelah jam mulai.',
        ]);
    }
}
