<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('join_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('code', 16)->unique();
            $table->string('campaign', 80)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('follow_on_join')->default(true);
            $table->timestamps();
            $table->index(['creator_id', 'is_active']);
        });

        Schema::create('join_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('join_link_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20)->index();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_hash', 64)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamps();
            $table->index(['join_link_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('join_events');
        Schema::dropIfExists('join_links');
    }
};
