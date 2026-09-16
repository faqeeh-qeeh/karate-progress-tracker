<?php

namespace App\Http\Controllers\Kohai;

use App\Http\Controllers\Controller;
use App\Models\Belt;
use App\Models\Department;
use App\Models\KohaiProfile;
use App\Models\Rank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan formulir biodata / profil Kohai.
     */
    public function index(): View
    {
        $user = Auth::user()->load([
            'kohaiProfile.rank.belt',
            'kohaiProfile.studyProgram.department',
            'kohaiProfile.academicClass',
        ]);

        $belts = Belt::with(['ranks' => fn($q) => $q->orderBy('order')])->orderBy('id')->get();
        $ranks = Rank::with('belt')->orderBy('order')->get();
        $departments = Department::with(['studyPrograms.academicClasses'])
            ->where('is_active', true)
            ->get();

        $profile = $user->kohaiProfile ?? new KohaiProfile(['type' => 'polindra']);

        return view('kohai.profile.index', compact('user', 'belts', 'ranks', 'departments', 'profile'));
    }

    /**
     * Perbarui data biodata / profil Kohai.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = KohaiProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['type' => 'polindra']
        );

        $memberType = $profile->type ?? 'polindra';

        // Aturan validasi dasar User & Kontak
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'address' => ['required', 'string'],
            'rank_id' => ['required', 'exists:ranks,id'],
            'weight' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'height' => ['nullable', 'numeric', 'min:50', 'max:250'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];

        // Validasi kondisional berdasarkan tipe Kohai yang ditetapkan Admin
        if ($memberType === 'polindra') {
            $rules['nim'] = ['required', 'string', 'max:50'];
            $rules['study_program_id'] = ['required', 'exists:study_programs,id'];
            $rules['academic_class_id'] = ['required', 'exists:academic_classes,id'];
            $rules['enrollment_year'] = ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)];
            $rules['high_school'] = ['required', 'string', 'max:255'];
        } else {
            $rules['institution'] = ['required', 'string', 'max:255'];
        }

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'phone.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'type.required' => 'Kategori asal anggota wajib dipilih.',
            'rank_id.required' => 'Tingkat sabuk wajib dipilih.',
            'rank_id.exists' => 'Pilihan tingkat sabuk tidak valid.',
            'nim.required' => 'NIM Polindra wajib diisi.',
            'study_program_id.required' => 'Program Studi wajib dipilih.',
            'study_program_id.exists' => 'Program Studi tidak valid.',
            'academic_class_id.required' => 'Kelas wajib dipilih.',
            'academic_class_id.exists' => 'Kelas tidak valid.',
            'enrollment_year.required' => 'Tahun masuk / angkatan wajib diisi.',
            'enrollment_year.min' => 'Tahun masuk tidak valid.',
            'high_school.required' => 'Asal sekolah SMA/SMK wajib diisi.',
            'institution.required' => 'Asal Sekolah / Instansi luar wajib diisi.',
            'weight.numeric' => 'Berat badan harus berupa angka.',
            'height.numeric' => 'Tinggi badan harus berupa angka.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ];

        $validated = $request->validate($rules, $messages);

        // Update User info
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Siapkan data Kohai Profile
        $profileData = [
            'type' => $memberType,
            'rank_id' => $validated['rank_id'],
            'weight' => $validated['weight'] ?? null,
            'height' => $validated['height'] ?? null,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
        ];

        if ($memberType === 'polindra') {
            $profileData['nim'] = $validated['nim'];
            $profileData['study_program_id'] = $validated['study_program_id'];
            $profileData['academic_class_id'] = $validated['academic_class_id'];
            $profileData['enrollment_year'] = $validated['enrollment_year'];
            $profileData['high_school'] = $validated['high_school'];
            $profileData['institution'] = null; // reset jika sebelumnya dari luar
        } else {
            $profileData['institution'] = $validated['institution'];
            $profileData['nim'] = null;
            $profileData['study_program_id'] = null;
            $profileData['academic_class_id'] = null;
            $profileData['enrollment_year'] = null;
            $profileData['high_school'] = null;
        }

        KohaiProfile::updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('kohai.profile.index')
            ->with('success', 'Biodata Kohai berhasil disimpan & diperbarui!');
    }
}
