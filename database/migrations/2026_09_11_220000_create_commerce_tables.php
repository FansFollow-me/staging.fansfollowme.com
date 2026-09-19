<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fan_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('status', 20)->default('active')->index();
            $table->unsignedInteger('price')->default(0);
            $table->string('currency', 3)->default('USD');
            $table->string('provider', 20)->nullable();
            $table->string('provider_subscription_id')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->unique(['fan_id', 'creator_id']);
            $table->index(['creator_id', 'status']);
        });

        Schema::create('ppv_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('amount')->default(0);
            $table->string('currency', 3)->default('USD');
            $table->string('provider', 20)->nullable();
            $table->string('provider_charge_id')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'post_id']);
        });

        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('to_creator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('post_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('amount')->default(0);
            $table->string('currency', 3)->default('USD');
            $table->string('message', 255)->nullable();
            $table->string('provider', 20)->nullable();
            $table->string('provider_charge_id')->nullable();
            $table->timestamps();
            $table->index(['to_creator_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tips');
        Schema::dropIfExists('ppv_purchases');
        Schema::dropIfExists('subscriptions');
    }
};
