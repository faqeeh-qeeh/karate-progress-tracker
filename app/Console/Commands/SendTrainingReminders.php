<?php

namespace App\Console\Commands;

use App\Mail\TrainingReminderMail;
use App\Models\TrainingSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTrainingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-training {--time= : Filter waktu pengiriman: pagi (hari H) atau malam (H-1)} {--schedule= : ID jadwal spesifik jika hanya ingin mengirim 1 jadwal}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email pengingat jadwal latihan karate ke Senpai dan Kohai';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $timeFilter = $this->option('time'); // 'pagi', 'malam', or null (check both/current)
        $scheduleId = $this->option('schedule');

        $this->info("=== Memulai Pengiriman Pengingat Jadwal Latihan ===");
        $now = Carbon::now();
        $this->info("Waktu saat ini: " . $now->format('Y-m-d H:i:s'));

        // Query active schedules with email_reminder enabled
        $query = TrainingSchedule::active()->where('email_reminder', true);

        if ($scheduleId) {
            $query->where('id', $scheduleId);
        }

        $allSchedules = $query->get();

        if ($allSchedules->isEmpty()) {
            $this->info("Tidak ada jadwal aktif dengan pengingat email.");
            return Command::SUCCESS;
        }

        $schedulesToNotify = [];

        foreach ($allSchedules as $schedule) {
            $scheduleReminderTime = $schedule->reminder_time ?? 'pagi';

            // Jika timeFilter ditentukan, lewati yang tidak cocok
            if ($timeFilter && $scheduleReminderTime !== $timeFilter) {
                continue;
            }

            // Cek target tanggal latihan:
            // Jika reminder_time == 'pagi' -> hari ini (H)
            // Jika reminder_time == 'malam' -> besok (H-1)
            $targetDate = ($scheduleReminderTime === 'malam') 
                ? Carbon::tomorrow() 
                : Carbon::today();

            if ($schedule->occursOn($targetDate)) {
                $schedulesToNotify[] = [
                    'schedule'    => $schedule,
                    'target_date' => $targetDate,
                    'time_type'   => $scheduleReminderTime,
                ];
            }
        }

        if (empty($schedulesToNotify)) {
            $this->info("Tidak ada jadwal latihan yang cocok untuk dikirimkan pengingat hari ini.");
            return Command::SUCCESS;
        }

        // Ambil penerima Senpai dan Kohai
        $senpais = User::whereHas('role', fn($q) => $q->where('nama', 'Senpai'))->get();
        $kohais = User::whereHas('role', fn($q) => $q->where('nama', 'Kohai'))->get();

        $this->info("Penerima: {$senpais->count()} Senpai, {$kohais->count()} Kohai.");

        $totalSent = 0;

        foreach ($schedulesToNotify as $item) {
            /** @var TrainingSchedule $schedule */
            $schedule   = $item['schedule'];
            $targetDate = $item['target_date'];
            $timeType   = $item['time_type'];

            $this->info("Mengirim pengingat: '{$schedule->title}' ({$schedule->type_label}) untuk tanggal {$targetDate->format('d/m/Y')} [Opsi: {$timeType}]");

            // Kirim ke semua Senpai
            foreach ($senpais as $senpai) {
                try {
                    Mail::to($senpai->email)->send(
                        new TrainingReminderMail($schedule, $senpai, 'senpai')
                    );
                    $totalSent++;
                } catch (\Throwable $e) {
                    $this->error("Gagal mengirim email ke Senpai {$senpai->email}: " . $e->getMessage());
                    Log::error("Gagal kirim pengingat latihan ke Senpai {$senpai->email}: " . $e->getMessage());
                }
            }

            // Kirim ke semua Kohai
            foreach ($kohais as $kohai) {
                try {
                    Mail::to($kohai->email)->send(
                        new TrainingReminderMail($schedule, $kohai, 'kohai')
                    );
                    $totalSent++;
                } catch (\Throwable $e) {
                    $this->error("Gagal mengirim email ke Kohai {$kohai->email}: " . $e->getMessage());
                    Log::error("Gagal kirim pengingat latihan ke Kohai {$kohai->email}: " . $e->getMessage());
                }
            }
        }

        $this->info("=== Selesai. Total email terkirim: {$totalSent} ===");
        return Command::SUCCESS;
    }
}
