<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('caption', 500)->nullable();
            $table->string('video_path');
            $table->string('thumbnail_path')->nullable();
            $table->string('status', 20)->default('published');
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
            $table->index(['creator_id', 'status']);
        });

        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 20)->default('media'); // media|text
            $table->text('body')->nullable();
            $table->string('media_path')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->index(['creator_id', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
        Schema::dropIfExists('reels');
    }
};
