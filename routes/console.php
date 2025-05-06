<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:prune-old-classes')->weeklyOn(0, '03:00');
Schedule::command('app:deactivate-inactive-users')->weeklyOn(0, '04:00');