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

        // 復習が必要な単語数
        $reviewCount = \App\Models\UserWordProgress::where('user_id', auth()->id())
            ->where('next_review_at', '<=', now())
            ->where('mastery_level', '<', 5)
            ->count();

        return view('quiz.index', compact('sections', 'totalQuizzes', 'correctQuizzes', 'averageScore', 'reviewCount'));
    }

    // クイズ開始（問題生成）
    public function start(Request $request)
    {
        $request->validate([
            'section'    => 'nullable|string',
            'difficulty' => 'nullable|in:easy,normal,hard',
            'count'      => 'required|integer|min:5|max:20',
            'mode'       => 'nullable|in:normal,review',
        ]);

        $userId = auth()->id();
        $count  = $request->count;

        if ($request->mode === 'review') {
            $reviewWordIds = \App\Models\UserWordProgress::where('user_id', $userId)
                ->where('next_review_at', '<=', now())
                ->where('mastery_level', '<', 5)
                ->pluck('word_id')
                ->toArray();

            $words = Word::whereIn('id', $reviewWordIds)
                ->inRandomOrder()
                ->limit($count)
                ->get();

            if ($words->count() < 1) {
                return back()->with('error', '現在復習が必要な単語がありません。');
            }
        } else {
            $query = Word::query();

            if ($request->filled('section')) {
                $query->where('section', $request->section);
            }
            if ($request->filled('difficulty')) {
                $query->where('difficulty', $request->difficulty);
            }

            $words = $query->inRandomOrder()->limit($count)->get();

            if ($words->count() < 1) {
                return back()->with('error', '条件に合う単語がありません。');
            }
        }

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

        QuizHistory::create([
            'user_id'     => auth()->id(),
            'word_id'     => $word->id,
            'is_correct'  => $isCorrect,
            'answered_at' => now(),
        ]);

        $progress = \App\Models\UserWordProgress::firstOrCreate(
            ['user_id' => auth()->id(), 'word_id' => $word->id],
            ['mastery_level' => 0]
        );

        if ($isCorrect) {
            $newLevel = min($progress->mastery_level + 1, 5);
        } else {
            $newLevel = max($progress->mastery_level - 1, 0);
        }

        $progress->update([
            'mastery_level'    => $newLevel,
            'last_reviewed_at' => now(),
            'next_review_at'   => \App\Models\UserWordProgress::calcNextReviewAt($newLevel),
        ]);

        session(['quiz_index' => $index + 1]);

        return redirect()->route('quiz.play');
    }

    // 結果画面
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

        // 習熟度データを取得
        $progressMap = \App\Models\UserWordProgress::where('user_id', auth()->id())
            ->whereIn('word_id', $wordIds)
            ->pluck('mastery_level', 'word_id');

        session()->forget(['quiz_words', 'quiz_index']);

        return view('quiz.result', compact('histories', 'correct', 'total', 'score', 'progressMap'));
    }
}