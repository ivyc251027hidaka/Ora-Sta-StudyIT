<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWordProgress extends Model
{
    protected $fillable = [
        'user_id',
        'word_id',
        'mastery_level',
        'last_reviewed_at',
        'next_review_at',
    ];

    protected $casts = [
        'last_reviewed_at' => 'datetime',
        'next_review_at'   => 'datetime',
    ];

    // 次回復習日を習熟度に応じて計算
    public static function calcNextReviewAt(int $level): \Carbon\Carbon
    {
        $days = match($level) {
            0 => 1,
            1 => 3,
            2 => 7,
            3 => 14,
            4 => 30,
            default => 365,
        };
        return now()->addDays($days);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}