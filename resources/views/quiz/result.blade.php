<x-sidebar title="クイズ結果">

    <div class="max-w-2xl">

        {{-- スコアカード --}}
        <div class="bg-white rounded-xl border border-gray-200 p-8 mb-6 text-center">
            <div class="w-24 h-24 rounded-full mx-auto mb-4 flex items-center justify-center text-3xl font-bold
                {{ $score >= 80 ? 'bg-green-100 text-green-600' : '' }}
                {{ $score >= 50 && $score < 80 ? 'bg-yellow-100 text-yellow-600' : '' }}
                {{ $score < 50 ? 'bg-red-100 text-red-600' : '' }}">
                {{ $score }}%
            </div>
            <p class="text-lg font-semibold text-gray-800 mb-1">{{ $correct }} / {{ $total }} 問正解</p>
            <p class="text-sm text-gray-500 mb-6">
                @if($score >= 80) 素晴らしい！この調子で頑張りましょう！
                @elseif($score >= 50) もう少しです！復習して再挑戦しましょう！
                @else まだまだ伸びしろがあります！単語を復習しましょう！
                @endif
            </p>

            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-1">正解数</p>
                    <p class="text-xl font-bold text-green-600">{{ $correct }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-1">不正解数</p>
                    <p class="text-xl font-bold text-red-500">{{ $total - $correct }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-1">正答率</p>
                    <p class="text-xl font-bold text-indigo-600">{{ $score }}%</p>
                </div>
            </div>

            <div class="flex gap-3 justify-center">
                <a href="{{ route('quiz.index') }}"
                   class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-indigo-700">もう一度挑戦</a>
                <a href="{{ route('words.index') }}"
                   class="bg-gray-100 text-gray-600 px-5 py-2 rounded-lg text-sm hover:bg-gray-200">単語一覧へ</a>
            </div>
        </div>

        {{-- 解答履歴 --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-sm font-semibold text-gray-700 mb-4">解答履歴</h2>
            <div class="flex flex-col gap-2">
                @foreach($histories as $history)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-700">{{ $history->word->term }}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $history->is_correct ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $history->is_correct ? '正解' : '不正解' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</x-sidebar>