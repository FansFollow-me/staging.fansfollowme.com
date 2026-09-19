<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (Schema::hasTable('app_notifications') && ! Schema::hasColumn('app_notifications', 'data')) {
    Schema::table('app_notifications', function (Blueprint $table) {
        $table->json('data')->nullable()->after('body');
    });
    echo "added data column\n";
} else {
    echo "data column ok or table missing\n";
}

echo Schema::hasColumn('app_notifications', 'data') ? "OK\n" : "FAIL\n";
