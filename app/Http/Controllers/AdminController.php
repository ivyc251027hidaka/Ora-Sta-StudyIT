<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 管理画面トップ
    public function index()
    {
        $words = Word::orderBy('created_at', 'desc')->paginate(15);
        $wordCount = Word::count();
        return view('admin.index', compact('words', 'wordCount'));
    }

    // 単語登録フォーム
    public function create()
    {
        return view('admin.words.create');
    }

    // 単語登録処理
    public function store(Request $request)
    {
        $request->validate([
            'term'        => 'required|string|max:255',
            'description' => 'required|string',
            'section'     => 'required|string|max:255',
            'difficulty'  => 'required|in:easy,normal,hard',
            'quiz_type'   => 'required|in:choice,written',
            'sql_example' => 'nullable|string',
        ]);

        Word::create($request->all());

        return redirect()->route('admin.index')->with('success', '単語を登録しました。');
    }

    // 単語編集フォーム
    public function edit(Word $word)
    {
        return view('admin.words.edit', compact('word'));
    }

    // 単語更新処理
    public function update(Request $request, Word $word)
    {
        $request->validate([
            'term'        => 'required|string|max:255',
            'description' => 'required|string',
            'section'     => 'required|string|max:255',
            'difficulty'  => 'required|in:easy,normal,hard',
            'quiz_type'   => 'required|in:choice,written',
            'sql_example' => 'nullable|string',
        ]);

        $word->update($request->all());

        return redirect()->route('admin.index')->with('success', '単語を更新しました。');
    }

    // 単語削除処理
    public function destroy(Word $word)
    {
        $word->delete();
        return redirect()->route('admin.index')->with('success', '単語を削除しました。');
    }
}