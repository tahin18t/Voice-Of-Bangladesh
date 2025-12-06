<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiInsight extends Model
{
    use HasFactory;

    protected $table = 'ai_insights';

    protected $fillable = [
        'feedback_id','summary','confidence_score','urgency_score','suggested_action','raw_payload','processed_at'
    ];

    protected $casts = [
        'raw_payload' => 'array',
        'processed_at' => 'datetime',
    ];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
