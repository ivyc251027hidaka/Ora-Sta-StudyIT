<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // お気に入り単語（多対多）
    // お気に入り単語（多対多）
    public function favorites()
    {
        return $this->belongsToMany(Word::class, 'favorites');
    }

    // クイズ履歴
    public function quizHistories()
    {
        return $this->hasMany(QuizHistory::class);
    }

    // 学習進捗
    public function wordProgress()
    {
        return $this->hasMany(UserWordProgress::class);
    }
}
