<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (! Schema::hasTable('withdrawal_requests')) {
    Schema::create('withdrawal_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
        $table->unsignedInteger('amount');
        $table->string('currency', 3)->default('USD');
        $table->string('method', 40)->default('bank');
        $table->string('details', 255)->nullable();
        $table->string('status', 20)->default('pending')->index();
        $table->string('admin_note')->nullable();
        $table->timestamp('processed_at')->nullable();
        $table->timestamps();
    });
    echo "created withdrawal_requests\n";
} else {
    echo "exists\n";
}

echo Schema::hasTable('withdrawal_requests') ? "OK\n" : "FAIL\n";
