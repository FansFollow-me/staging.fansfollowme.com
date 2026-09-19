<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('feature', 80);
            $table->text('message')->nullable();
            $table->string('source', 40)->default('coming_soon');
            $table->timestamps();
            $table->index('feature');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_requests');
    }
};
