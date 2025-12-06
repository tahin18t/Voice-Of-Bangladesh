<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feedback_id')->nullable()->constrained('feedbacks')->nullOnDelete();
            $table->string('summary')->nullable();
            $table->float('confidence_score')->nullable();
            $table->float('urgency_score')->nullable();
            $table->text('suggested_action')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_insights');
    }
};
