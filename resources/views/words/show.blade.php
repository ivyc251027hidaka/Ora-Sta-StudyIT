<x-sidebar title="単語詳細">

    <div class="max-w-3xl">
        <a href="{{ route('words.index') }}"
           class="text-xs text-gray-500 hover:text-gray-700 mb-4 inline-block">← 単語一覧に戻る</a>

        {{-- メインカード --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-700">{{ $word->section }}</span>
                <span class="text-xs px-2 py-1 rounded-full
                    {{ $word->difficulty === 'easy' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $word->difficulty === 'normal' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $word->difficulty === 'hard' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ $word->difficulty === 'easy' ? '易しい' : ($word->difficulty === 'normal' ? '普通' : '難しい') }}
                </span>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-3">{{ $word->term }}</h1>

            {{-- 習熟度表示 --}}
            <div class="flex items-center gap-2 mb-4">
                <span class="text-xs text-gray-400">習熟度：</span>
                @php $level = $progress ? $progress->mastery_level : 0; @endphp
                <div class="flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <div class="w-6 h-2 rounded-full {{ $i <= $level ? 'bg-indigo-500' : 'bg-gray-200' }}"></div>
                    @endfor
                </div>
                <span class="text-xs text-gray-500">
                    @if($level == 0) 未学習
                    @elseif($level <= 2) 学習中
                    @elseif($level <= 4) 定着中
                    @else 習得済み
                    @endif
                </span>
                @if($progress && $progress->next_review_at)
                    <span class="text-xs text-gray-400 ml-2">次回復習：{{ $progress->next_review_at->format('m/d') }}</span>
                @endif
            </div>

            <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ $word->description }}</p>

            <div class="flex gap-3">
                <form method="POST" action="{{ route('favorites.toggle', $word) }}">
                    @csrf
                    <button type="submit"
                            class="text-xs px-3 py-1.5 rounded-lg border border-yellow-300 text-yellow-600 hover:bg-yellow-50">
                        ⭐ お気に入り{{ auth()->user()->favorites()->where('word_id', $word->id)->exists() ? '解除' : '追加' }}
                    </button>
                </form>
                <a href="{{ route('words.index') }}"
                   class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-200">← 一覧に戻る</a>
            </div>
        </div>

        {{-- SQL使用例 --}}
        @if($word->sql_example)
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
            <h2 class="text-sm font-semibold text-gray-700 mb-3">SQL使用例</h2>
            <pre class="bg-gray-900 text-green-400 rounded-lg p-4 text-xs overflow-x-auto font-mono">{{ $word->sql_example }}</pre>
        </div>
        @endif

        {{-- 学習情報 --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-sm font-semibold text-gray-700 mb-3">学習情報</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-1">カテゴリ</p>
                    <p class="text-gray-700">{{ $word->section }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">難易度</p>
                    <p class="text-gray-700">{{ $word->difficulty === 'easy' ? '易しい' : ($word->difficulty === 'normal' ? '普通' : '難しい') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">出題形式</p>
                    <p class="text-gray-700">{{ $word->quiz_type === 'choice' ? '4択' : '記述' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">登録日</p>
                    <p class="text-gray-700">{{ $word->created_at->format('Y年m月d日') }}</p>
                </div>
            </div>
        </div>
    </div>

</x-sidebar>