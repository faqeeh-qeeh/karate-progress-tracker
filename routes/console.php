<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Pengingat jadwal latihan karate pagi hari (06:00 WIB di hari H)
Schedule::command('reminders:send-training --time=pagi')
    ->dailyAt('06:00')
    ->name('send-morning-training-reminders')
    ->withoutOverlapping();

// Pengingat jadwal latihan karate malam hari (20:00 WIB di malam H-1)
Schedule::command('reminders:send-training --time=malam')
    ->dailyAt('20:00')
    ->name('send-night-training-reminders')
    ->withoutOverlapping();

