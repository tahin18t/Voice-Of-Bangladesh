<?php

namespace App\Services;

use App\Models\Feedback;
use App\Models\AiInsight;

class AiAnalysisService
{
    /**
     * Analyze feedback and generate AI insights
     */
    public function analyzeFeedback(Feedback $feedback)
    {
        // Extract text for analysis
        $text = strtolower($feedback->title . ' ' . $feedback->description);

        // Get insights from analysis
        $insights = [
            'summary' => $this->generateSummary($feedback),
            'category_confidence' => $this->calculateCategoryConfidence($text, $feedback->category),
            'urgency_score' => $this->calculateUrgencyScore($text),
            'priority_classification' => $this->classifyPriority($text),
            'suggested_action' => $this->suggestAction($feedback),
            'keywords' => $this->extractKeywords($text),
            'sentiment' => $this->analyzeSentiment($text),
        ];

        // Store AI insight
        $aiInsight = AiInsight::updateOrCreate(
            ['feedback_id' => $feedback->id],
            [
                'summary' => $insights['summary'],
                'confidence_score' => $insights['category_confidence'],
                'urgency_score' => $insights['urgency_score'],
                'suggested_action' => $insights['suggested_action'],
                'raw_payload' => $insights,
                'processed_at' => now(),
            ]
        );

        return $aiInsight;
    }

    /**
     * Generate summary from feedback
     */
    private function generateSummary(Feedback $feedback)
    {
        $text = $feedback->description;

        // Simple summary: first 200 characters
        if (strlen($text) > 200) {
            return substr($text, 0, 197) . '...';
        }

        return $text;
    }

    /**
     * Calculate category confidence (0-100)
     */
    private function calculateCategoryConfidence($text, $category)
    {
        $keywords = $this->getCategoryKeywords($category);
        $matches = 0;

        foreach ($keywords as $keyword) {
            if (strpos($text, strtolower($keyword)) !== false) {
                $matches++;
            }
        }

        // Base confidence: 60% + 5% per keyword match (up to 95%)
        return min(95, 60 + ($matches * 5));
    }

    /**
     * Calculate urgency score (0-100)
     */
    private function calculateUrgencyScore($text)
    {
        $urgentKeywords = [
            'emergency' => 95,
            'urgent' => 85,
            'critical' => 90,
            'danger' => 88,
            'accident' => 80,
            'injured' => 85,
            'fire' => 95,
            'flood' => 90,
            'immediately' => 80,
        ];

        $score = 40; // Base score

        foreach ($urgentKeywords as $keyword => $value) {
            if (strpos($text, $keyword) !== false) {
                $score = max($score, $value);
            }
        }

        return $score;
    }

    /**
     * Classify feedback priority
     */
    private function classifyPriority($text)
    {
        $urgency = $this->calculateUrgencyScore($text);

        if ($urgency >= 85) {
            return 'critical';
        } elseif ($urgency >= 70) {
            return 'high';
        } elseif ($urgency >= 50) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    /**
     * Suggest action based on feedback
     */
    private function suggestAction(Feedback $feedback)
    {
        $category = strtolower($feedback->category);
        $priority = $feedback->priority;

        $suggestions = [
            'sanitation' => [
                'critical' => 'Immediate inspection and cleanup required. Contact health department.',
                'high' => 'Schedule sanitation inspection within 24 hours.',
                'medium' => 'Add to cleanup schedule for this week.',
                'low' => 'Monitor and include in routine sanitation checks.',
            ],
            'infrastructure' => [
                'critical' => 'Emergency repair required. Cordon off affected area if hazardous.',
                'high' => 'Schedule repair inspection within 48 hours.',
                'medium' => 'Plan repair for next maintenance cycle.',
                'low' => 'Monitor and assess before next budget cycle.',
            ],
            'water' => [
                'critical' => 'Urgent water quality test required. Issue public notice if applicable.',
                'high' => 'Conduct water test within 24 hours.',
                'medium' => 'Include in weekly water quality checks.',
                'low' => 'Monitor in routine water testing.',
            ],
            'default' => [
                'critical' => 'Escalate to senior management immediately.',
                'high' => 'Assign to appropriate department for investigation.',
                'medium' => 'Review and prioritize in next team meeting.',
                'low' => 'File for future reference and monitoring.',
            ]
        ];

        $categoryActions = $suggestions[$category] ?? $suggestions['default'];

        return $categoryActions[$priority] ?? $categoryActions['medium'];
    }

    /**
     * Extract keywords from text
     */
    private function extractKeywords($text)
    {
        $stopwords = ['the', 'a', 'an', 'and', 'or', 'but', 'is', 'are', 'was', 'were', 'be', 'been'];

        $words = str_word_count($text, 1);
        $keywords = array_filter($words, function ($word) use ($stopwords) {
            return strlen($word) > 3 && !in_array($word, $stopwords);
        });

        return array_slice(array_values($keywords), 0, 10);
    }

    /**
     * Analyze sentiment
     */
    private function analyzeSentiment($text)
    {
        $negative = ['bad', 'terrible', 'awful', 'horrible', 'poor', 'worst', 'hate', 'angry', 'frustrated'];
        $positive = ['good', 'excellent', 'great', 'happy', 'satisfied', 'perfect', 'love'];

        $negScore = 0;
        $posScore = 0;

        foreach ($negative as $word) {
            $negScore += substr_count($text, $word);
        }

        foreach ($positive as $word) {
            $posScore += substr_count($text, $word);
        }

        if ($negScore > $posScore) {
            return 'negative';
        } elseif ($posScore > $negScore) {
            return 'positive';
        }

        return 'neutral';
    }

    /**
     * Get keywords for category
     */
    private function getCategoryKeywords($category)
    {
        $categoryKeywords = [
            'sanitation' => ['garbage', 'waste', 'dirt', 'litter', 'rubbish', 'dump', 'clean'],
            'infrastructure' => ['road', 'bridge', 'pipe', 'damaged', 'broken', 'repair', 'construction'],
            'water' => ['water', 'supply', 'pipe', 'leakage', 'quality', 'contamination', 'pressure'],
            'traffic' => ['traffic', 'signal', 'road', 'accident', 'congestion', 'pothole'],
            'electricity' => ['power', 'electricity', 'blackout', 'failure', 'line', 'outage'],
            'general' => ['issue', 'problem', 'complaint', 'feedback'],
        ];

        return $categoryKeywords[strtolower($category)] ?? $categoryKeywords['general'];
    }
}
