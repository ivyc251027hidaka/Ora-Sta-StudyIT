<x-sidebar title="お気に入り単語">

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($words->count() > 0)
        <div class="grid grid-cols-3 gap-4 mb-6">
            @foreach($words as $word)
                <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $word->difficulty === 'easy' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $word->difficulty === 'normal' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $word->difficulty === 'hard' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $word->difficulty === 'easy' ? '易しい' : ($word->difficulty === 'normal' ? '普通' : '難しい') }}
                        </span>
                        <form method="POST" action="{{ route('favorites.toggle', $word) }}">
                            @csrf
                            <button type="submit" class="text-yellow-400 hover:text-gray-400 text-lg">⭐</button>
                        </form>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800 mb-1">{{ $word->term }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-2">{{ $word->description }}</p>
                    <a href="{{ route('words.show', $word) }}"
                        class="mt-3 inline-block text-xs text-indigo-600 hover:underline">詳しく見る →</a>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center">
            {{ $words->links() }}
        </div>

    @else
        <div class="text-center py-16 text-gray-400">
            <p class="text-4xl mb-3">⭐</p>
            <p class="text-sm">お気に入りに登録した単語がありません。</p>
            <a href="{{ route('words.index') }}"
               class="mt-3 inline-block text-xs text-indigo-600 hover:underline">単語一覧へ</a>
        </div>
    @endif

</x-sidebar>