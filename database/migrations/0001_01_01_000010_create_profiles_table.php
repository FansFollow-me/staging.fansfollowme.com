<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('display_name', 80)->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('cover_path')->nullable();
            $table->string('category', 80)->nullable()->index();
            $table->string('gender', 40)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('website')->nullable();
            $table->json('socials')->nullable();
            $table->timestamps();
        });

        Schema::create('creator_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('subscription_price')->default(0);
            $table->string('currency', 3)->default('USD');
            $table->text('welcome_message')->nullable();
            $table->unsignedInteger('video_call_price')->default(0);
            $table->unsignedInteger('audio_call_price')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->boolean('accepts_subscriptions')->default(true);
            $table->timestamps();
        });

        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['follower_id', 'creator_id']);
            $table->index('creator_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
        Schema::dropIfExists('creator_settings');
        Schema::dropIfExists('user_profiles');
    }
};
