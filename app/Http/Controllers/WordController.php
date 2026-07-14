<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    // 単語一覧
    // 単語一覧
    public function index(Request $request)
    {
        $query = Word::query();

        if ($request->filled('search')) {
            $query->where('term', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $words = $query->orderBy('term')->paginate(12);
        $sections = Word::distinct()->pluck('section');

        // ログインユーザーの習熟度を取得
        $progressMap = \App\Models\UserWordProgress::where('user_id', auth()->id())
            ->pluck('mastery_level', 'word_id');

        return view('words.index', compact('words', 'sections', 'progressMap'));
    }

    // 単語詳細
    // 単語詳細
    public function show(Word $word)
    {
        $progress = \App\Models\UserWordProgress::where('user_id', auth()->id())
            ->where('word_id', $word->id)
            ->first();

        return view('words.show', compact('word', 'progress'));
    }
}