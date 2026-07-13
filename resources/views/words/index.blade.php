<x-sidebar title="単語一覧">

    {{-- 検索・フィルター --}}
    <form method="GET" action="{{ route('words.index') }}" class="mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="SQLキーワードを検索..."
                class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">

            <select name="section" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">カテゴリ（すべて）</option>
                @foreach($sections as $section)
                    <option value="{{ $section }}" {{ request('section') == $section ? 'selected' : '' }}>
                        {{ $section }}
                    </option>
                @endforeach
            </select>

            <select name="difficulty" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">難易度（すべて）</option>
                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>易しい</option>
                <option value="normal" {{ request('difficulty') == 'normal' ? 'selected' : '' }}>普通</option>
                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>難しい</option>
            </select>

            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
                検索
            </button>
        </div>
    </form>
    {{-- 単語カードグリッド --}}
    @if($words->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @foreach($words as $word)
                <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md transition overflow-hidden">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $word->difficulty === 'easy' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $word->difficulty === 'normal' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $word->difficulty === 'hard' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $word->difficulty === 'easy' ? '易しい' : ($word->difficulty === 'normal' ? '普通' : '難しい') }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $word->section }}</span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800 mb-1">{{ $word->term }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-2 break-words overflow-hidden">{{ $word->description }}</p>
                    <a href="{{ route('words.show', $word) }}"
                        class="mt-3 inline-block text-xs text-indigo-600 hover:underline">詳しく見る →</a>
                </div>
            @endforeach
        </div>

        {{-- ページネーション --}}
        <div class="flex justify-center">
            {{ $words->links() }}
        </div>

    @else
        <div class="text-center py-16 text-gray-400">
            <p class="text-4xl mb-3">📚</p>
            <p class="text-sm">単語がまだ登録されていません。</p>
        </div>
    @endif

</x-sidebar>