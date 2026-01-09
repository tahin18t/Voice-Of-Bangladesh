<?php

namespace App\Jobs;

use App\Models\Feedback;
use App\Models\AiInsight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeFeedbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Feedback $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function handle(): void
    {
        // This is a stubbed analyzer — replace with real AI integration
        $summary = substr($this->feedback->description ?? $this->feedback->title, 0, 200);

        $insight = AiInsight::create([
            'feedback_id' => $this->feedback->id,
            'summary' => $summary,
            'confidence_score' => 85.0,
            'urgency_score' => 7.5,
            'suggested_action' => 'Schedule site inspection within 48 hours',
            'raw_payload' => ['stub' => true],
            'processed_at' => now(),
        ]);

        // link insight to feedback
        $this->feedback->ai_insight_id = $insight->id;
        $this->feedback->save();
    }
}
