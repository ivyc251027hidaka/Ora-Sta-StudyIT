<?php

namespace App\Http\Controllers;

use App\Models\QuizHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = QuizHistory::where('user_id', auth()->id())
            ->with('word')
            ->latest('answered_at')
            ->paginate(20);

        $totalQuizzes   = QuizHistory::where('user_id', auth()->id())->count();
        $correctQuizzes = QuizHistory::where('user_id', auth()->id())->where('is_correct', true)->count();
        $averageScore   = $totalQuizzes > 0 ? round($correctQuizzes / $totalQuizzes * 100) : 0;

        return view('history.index', compact('histories', 'totalQuizzes', 'correctQuizzes', 'averageScore'));
    }
}