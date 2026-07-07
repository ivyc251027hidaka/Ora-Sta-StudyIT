<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\QuizHistory;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // クイズ設定画面
    public function index()
    {
        $sections = Word::distinct()->pluck('section');
        $totalQuizzes = QuizHistory::where('user_id', auth()->id())->count();
        $correctQuizzes = QuizHistory::where('user_id', auth()->id())->where('is_correct', true)->count();
        $averageScore = $totalQuizzes > 0 ? round($correctQuizzes / $totalQuizzes * 100) : 0;

        return view('quiz.index', compact('sections', 'totalQuizzes', 'correctQuizzes', 'averageScore'));
    }

    // クイズ開始（問題生成）
    public function start(Request $request)
    {
        $request->validate([
            'section'    => 'nullable|string',
            'difficulty' => 'nullable|in:easy,normal,hard',
            'count'      => 'required|integer|min:5|max:20',
        ]);

        $query = Word::query();

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $words = $query->inRandomOrder()->limit($request->count)->get();

        if ($words->count() < 1) {
            return back()->with('error', '条件に合う単語がありません。');
        }

        // セッションに問題リストを保存
        session(['quiz_words' => $words->pluck('id')->toArray(), 'quiz_index' => 0]);

        return redirect()->route('quiz.play');
    }

    // クイズ出題画面
    public function play()
    {
        $wordIds = session('quiz_words', []);
        $index   = session('quiz_index', 0);

        if (empty($wordIds) || $index >= count($wordIds)) {
            return redirect()->route('quiz.result');
        }

        $word = Word::find($wordIds[$index]);
        $total = count($wordIds);

        // 4択の選択肢を生成（正解＋ランダム3つ）
        $choices = Word::where('id', '!=', $word->id)->inRandomOrder()->limit(3)->pluck('term')->toArray();
        $choices[] = $word->term;
        shuffle($choices);

        return view('quiz.play', compact('word', 'choices', 'index', 'total'));
    }

    // 解答処理
    public function answer(Request $request)
    {
        $wordIds = session('quiz_words', []);
        $index   = session('quiz_index', 0);
        $word    = Word::find($wordIds[$index]);

        $isCorrect = $request->answer === $word->term;

        // 解答履歴を保存
        QuizHistory::create([
            'user_id'     => auth()->id(),
            'word_id'     => $word->id,
            'is_correct'  => $isCorrect,
            'answered_at' => now(),
        ]);

        // 次の問題へ
        session(['quiz_index' => $index + 1]);

        return redirect()->route('quiz.play');
    }

    // 結果画面
    public function result()
    {
        $wordIds = session('quiz_words', []);

        if (empty($wordIds)) {
            return redirect()->route('quiz.index');
        }

        $histories = QuizHistory::where('user_id', auth()->id())
            ->whereIn('word_id', $wordIds)
            ->latest()
            ->limit(count($wordIds))
            ->get();

        $correct = $histories->where('is_correct', true)->count();
        $total   = $histories->count();
        $score   = $total > 0 ? round($correct / $total * 100) : 0;

        // セッションクリア
        session()->forget(['quiz_words', 'quiz_index']);

        return view('quiz.result', compact('histories', 'correct', 'total', 'score'));
    }
}