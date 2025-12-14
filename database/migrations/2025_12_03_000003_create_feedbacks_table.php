<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->enum('priority', ['low','medium','high'])->default('low');
            $table->enum('status', ['pending','in-progress','resolved','closed'])->default('pending');
            $table->string('location')->nullable();
            $table->json('attachments')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('ai_insight_id')->nullable()->index();
            $table->timestamps();

            $table->index(['status','priority','category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
