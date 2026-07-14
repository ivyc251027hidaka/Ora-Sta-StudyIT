<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\QuizHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 登録単語数
        $wordCount = Word::count();

        // クイズ正答率
        $totalQuizzes   = QuizHistory::where('user_id', $user->id)->count();
        $correctQuizzes = QuizHistory::where('user_id', $user->id)->where('is_correct', true)->count();
        $averageScore   = $totalQuizzes > 0 ? round($correctQuizzes / $totalQuizzes * 100) : null;

        // 連続学習日数
        $streak = 0;
        $date = now()->startOfDay();

        while (true) {
            $hasQuiz = QuizHistory::where('user_id', $user->id)
                ->whereDate('answered_at', $date)
                ->exists();

            if ($hasQuiz) {
                $streak++;
                $date = $date->copy()->subDay();
            } else {
                break;
            }
        }

        // 今日の単語（ランダム1件）
        $todayWord = Word::inRandomOrder()->first();

        // 最近学習した単語（直近5件）
        $recentWords = QuizHistory::where('user_id', $user->id)
            ->with('word')
            ->latest('answered_at')
            ->limit(5)
            ->get()
            ->pluck('word')
            ->unique('id');

        // お気に入り登録数
        $favoriteCount = $user->favorites()->count();

        return view('dashboard', compact(
            'wordCount',
            'totalQuizzes',
            'averageScore',
            'todayWord',
            'recentWords',
            'favoriteCount',
            'streak'
        ));
    }
}