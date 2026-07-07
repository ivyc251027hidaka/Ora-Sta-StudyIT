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

        // 学習進捗（お気に入り登録数 / 総単語数）
        $favoriteCount = $user->favorites()->count();

        return view('dashboard', compact(
            'wordCount',
            'totalQuizzes',
            'averageScore',
            'todayWord',
            'recentWords',
            'favoriteCount'
        ));
    }
}