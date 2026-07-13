<x-sidebar title="クイズ">

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- クイズ設定カード --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6 max-w-2xl">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">クイズを設定してスタート</h2>
        <form method="POST" action="{{ route('quiz.start') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">カテゴリ</label>
                    <select name="section" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        <option value="">すべて</option>
                        @foreach($sections as $section)
                            <option value="{{ $section }}">{{ $section }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">難易度</label>
                    <select name="difficulty" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        <option value="">すべて</option>
                        <option value="easy">易しい</option>
                        <option value="normal">普通</option>
                        <option value="hard">難しい</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">問題数</label>
                    <select name="count" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        <option value="5">5問</option>
                        <option value="10" selected>10問</option>
                        <option value="20">20問</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" name="mode" value="normal"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700">
                    通常クイズ
                </button>
                <button type="submit" name="mode" value="review"
                        class="bg-orange-500 text-white px-6 py-2 rounded-lg text-sm hover:bg-orange-600 flex items-center gap-2">
                    🔁 復習クイズ
                    @if($reviewCount > 0)
                        <span class="bg-white text-orange-500 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $reviewCount }}</span>
                    @endif
                </button>
            </div>
        </form>
    </div>

    {{-- 成績サマリー --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">これまでの成績</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-gray-400 mb-1">総解答数</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $totalQuizzes }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">正解数</p>
                <p class="text-2xl font-bold text-green-600">{{ $correctQuizzes }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">正答率</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $averageScore }}<span class="text-sm font-normal text-gray-400"> %</span></p>
            </div>
        </div>
    </div>

</x-sidebar>