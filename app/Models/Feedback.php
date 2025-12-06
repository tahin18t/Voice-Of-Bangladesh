<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id','user_id','title','description','category','priority','status','location','attachments','assigned_to','ai_insight_id'
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function aiInsight()
    {
        return $this->hasOne(AiInsight::class, 'feedback_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
