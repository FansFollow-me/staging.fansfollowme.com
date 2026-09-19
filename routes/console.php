<?php

// Laravel will load this after composer install provides the framework.
// Minimal stub so static analysis tools see a routes file.

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
