<?php

namespace App\Services;

use App\Models\Feedback;

class AiAnalyzer
{
    public function analyze(Feedback $feedback): array
    {
        // Replace this stub with actual AI service integration (HTTP client, SDK, etc.)
        $summary = substr($feedback->description ?? $feedback->title, 0, 300);
        return [
            'summary' => $summary,
            'confidence_score' => 90.0,
            'urgency_score' => 6.8,
            'suggested_action' => 'Investigate and assign to field team',
            'raw' => ['stub' => true],
        ];
    }
}
