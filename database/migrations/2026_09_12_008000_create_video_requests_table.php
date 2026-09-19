<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fan_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('price');
            $table->string('currency', 3)->default('USD');
            $table->string('occasion', 80)->nullable();
            $table->text('brief')->nullable();
            $table->string('status', 20)->default('pending')->index();
            $table->string('video_path')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
            $table->index(['creator_id', 'status']);
            $table->index(['fan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_requests');
    }
};
