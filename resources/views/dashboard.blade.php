<x-sidebar title="ホーム">

    {{-- 統計カード --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-1">連続学習日数</p>
            <p class="text-2xl font-bold text-indigo-600">1 <span class="text-sm font-normal text-gray-400">日</span></p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-1">登録単語数</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $wordCount }} <span class="text-sm font-normal text-gray-400">語</span></p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-1">クイズ正答率</p>
            <p class="text-2xl font-bold text-indigo-600">
                {{ $averageScore !== null ? $averageScore : '-' }}
                <span class="text-sm font-normal text-gray-400">%</span>
            </p>
        </div>
    </div>

    {{-- Today's Word / Today's Quiz --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-2">Today's Word</p>
            @if($todayWord)
                <p class="text-sm font-bold text-gray-800 mb-1">{{ $todayWord->term }}</p>
                <p class="text-xs text-gray-500 line-clamp-2">{{ $todayWord->description }}</p>
                <a href="{{ route('words.show', $todayWord) }}"
                   class="mt-3 inline-block text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg">詳しく見る</a>
            @else
                <p class="text-sm text-gray-400">単語データを登録すると表示されます。</p>
            @endif
        </div>
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-4 text-white">
            <p class="text-xs opacity-80 mb-2">Today's Quiz</p>
            <p class="text-sm opacity-90 mb-3">今日の知識を試してみましょう！</p>
            <a href="{{ route('quiz.index') }}"
               class="inline-block text-xs bg-white text-indigo-600 font-semibold px-3 py-1 rounded-lg">START QUIZ</a>
        </div>
    </div>

    {{-- 学習進捗・最近の単語 --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-2">お気に入り登録数</p>
            <div class="w-full bg-gray-100 rounded-full h-2 mb-1">
                <div class="bg-indigo-500 h-2 rounded-full"
                     style="width: {{ $wordCount > 0 ? round($favoriteCount / $wordCount * 100) : 0 }}%"></div>
            </div>
            <p class="text-xs text-gray-400">{{ $favoriteCount }} / {{ $wordCount }} 語</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-2">最近学習した単語</p>
            @if($recentWords->count() > 0)
                <div class="flex flex-col gap-1">
                    @foreach($recentWords as $word)
                        <a href="{{ route('words.show', $word) }}"
                           class="text-xs text-indigo-600 hover:underline">{{ $word->term }}</a>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400">まだ学習記録がありません。</p>
            @endif
        </div>
    </div>

</x-sidebar>