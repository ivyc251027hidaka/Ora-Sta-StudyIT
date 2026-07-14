<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    // 単語一覧
    public function index(Request $request)
    {
        $query = Word::query();

        // キーワード検索
        if ($request->filled('search')) {
            $query->where('term', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // カテゴリ絞り込み
        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        // 難易度絞り込み
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $words = $query->orderBy('term')->paginate(12);
        $sections = Word::distinct()->pluck('section');

        return view('words.index', compact('words', 'sections'));
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