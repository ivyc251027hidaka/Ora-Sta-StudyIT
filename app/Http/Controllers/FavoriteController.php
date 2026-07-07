<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // お気に入り一覧
    public function index()
    {
        $words = auth()->user()->favorites()->paginate(12);
        return view('favorites.index', compact('words'));
    }

    // お気に入り追加・解除（トグル）
    public function toggle(Word $word)
    {
        $user = auth()->user();

        if ($user->favorites()->where('word_id', $word->id)->exists()) {
            $user->favorites()->detach($word->id);
            $message = 'お気に入りから削除しました。';
        } else {
            $user->favorites()->attach($word->id);
            $message = 'お気に入りに追加しました。';
        }

        return back()->with('success', $message);
    }
}