<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'term',
        'description',
        'sql_example',
        'section',
        'difficulty',
        'quiz_type',
        'choices',
    ];

    protected $casts = [
        'choices' => 'array',
    ];

    // お気に入り登録したユーザー（多対多）
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    // クイズ履歴
    public function quizHistories()
    {
        return $this->hasMany(QuizHistory::class);
    }

    // 学習進捗
    public function userProgress()
    {
        return $this->hasMany(UserWordProgress::class);
    }
}