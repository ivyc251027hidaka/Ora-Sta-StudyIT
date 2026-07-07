<x-sidebar title="学習履歴">

    {{-- 統計カード --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-1">総解答数</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $totalQuizzes }} <span class="text-sm font-normal text-gray-400">問</span></p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-1">正解数</p>
            <p class="text-2xl font-bold text-green-600">{{ $correctQuizzes }} <span class="text-sm font-normal text-gray-400">問</span></p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-1">平均正答率</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $averageScore }} <span class="text-sm font-normal text-gray-400">%</span></p>
        </div>
    </div>

    {{-- 履歴テーブル --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">クイズ解答履歴</h2>
        </div>

        @if($histories->count() > 0)
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500">
                    <tr>
                        <th class="text-left px-4 py-2">単語</th>
                        <th class="text-left px-4 py-2">カテゴリ</th>
                        <th class="text-left px-4 py-2">結果</th>
                        <th class="text-left px-4 py-2">解答日時</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($histories as $history)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium text-gray-800">
                                <a href="{{ route('words.show', $history->word) }}"
                                   class="hover:text-indigo-600">{{ $history->word->term }}</a>
                            </td>
                            <td class="px-4 py-2 text-gray-500">{{ $history->word->section }}</td>
                            <td class="px-4 py-2">
                                <span class="text-xs px-2 py-0.5 rounded-full
                                    {{ $history->is_correct ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    {{ $history->is_correct ? '正解' : '不正解' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-gray-400 text-xs">
                                {{ $history->answered_at->format('Y/m/d H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $histories->links() }}
            </div>

        @else
            <div class="text-center py-16 text-gray-400">
                <p class="text-4xl mb-3">📈</p>
                <p class="text-sm">まだクイズの解答履歴がありません。</p>
                <a href="{{ route('quiz.index') }}"
                   class="mt-3 inline-block text-xs text-indigo-600 hover:underline">クイズに挑戦する</a>
            </div>
        @endif
    </div>

</x-sidebar>