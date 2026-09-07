<x-sidebar title="学習履歴">

    {{-- 統計カード --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- 月間カレンダー --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-gray-700">{{ $now->format('Y年n月') }}の学習記録</h2>
                @if($selectedDate)
                    <a href="{{ route('history.index') }}" class="text-xs text-indigo-600 hover:underline">絞り込み解除</a>
                @endif
            </div>
            <div class="grid grid-cols-7 gap-1 text-center text-xs text-gray-400 mb-1">
                <div>日</div><div>月</div><div>火</div><div>水</div><div>木</div><div>金</div><div>土</div>
            </div>
            <div class="grid grid-cols-7 gap-1">
                @for($i = 0; $i < $firstDayOfWeek; $i++)
                    <div></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $date = $now->copy()->startOfMonth()->addDays($day - 1)->format('Y-m-d');
                        $data = $monthlyData[$date] ?? null;
                        $isToday = $date === now()->format('Y-m-d');
                        $isSelected = $date === $selectedDate;
                    @endphp
                    <a href="{{ route('history.index', ['date' => $date]) }}"
                       class="flex flex-col items-center py-1 rounded-lg {{ $isSelected ? 'bg-indigo-50 ring-1 ring-indigo-300' : 'hover:bg-gray-50' }}">
                        <span class="text-xs {{ $isToday ? 'font-bold text-indigo-600' : 'text-gray-500' }}">{{ $day }}</span>
                        @if($data && $data->count > 0)
                            <div class="w-5 h-5 rounded-full mt-0.5 flex items-center justify-center
                                {{ $data->correct / $data->count >= 0.8 ? 'bg-green-500' : ($data->correct / $data->count >= 0.5 ? 'bg-yellow-400' : 'bg-red-400') }}">
                                <span class="text-white" style="font-size:8px;">{{ $data->count }}</span>
                            </div>
                        @else
                            <div class="w-5 h-5 rounded-full mt-0.5 bg-gray-100"></div>
                        @endif
                    </a>
                @endfor
            </div>
            <div class="flex items-center gap-3 mt-3 text-xs text-gray-400">
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>80%以上</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span>50%以上</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>50%未満</span>
            </div>
        </div>

        {{-- グラフ --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-gray-700">学習量グラフ</h2>
                <div class="flex gap-1">
                    @foreach(['day' => '1日', 'week' => '1週間', 'month' => '1ヶ月', 'year' => '年間'] as $key => $label)
                        <a href="{{ route('history.index', ['period' => $key]) }}"
                           class="px-2 py-1 text-xs rounded-lg {{ $period === $key ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
                        <div class="flex items-end gap-1 h-48">
                @php
                    $counts = array_column($graphData, 'count');
                    $maxCount = count($counts) > 0 ? max(max($counts), 1) : 1;
                @endphp
                @foreach($graphData as $day)
                    @php
                        $height = $day['count'] > 0 ? max(($day['count'] / $maxCount) * 100, 5) : 2;
                        $correctRate = $day['count'] > 0 ? $day['correct'] / $day['count'] : 0;
                        $barColor = $day['count'] > 0
                            ? ($correctRate >= 0.8 ? '#22c55e' : ($correctRate >= 0.5 ? '#facc15' : '#f87171'))
                            : '#e5e7eb';
                    @endphp
                    <div class="flex-1 flex flex-col items-center group relative">
                        {{-- 解答数 --}}
                        @if($day['count'] > 0)
                            <span class="text-xs font-bold mb-0.5" style="color: {{ $barColor }}; font-size: 9px;">
                                {{ $day['count'] }}
                            </span>
                        @else
                            <span style="font-size: 9px;" class="mb-0.5">&nbsp;</span>
                        @endif
                        {{-- 棒 --}}
                        <div class="w-full rounded-t transition-all"
                             style="height: {{ $height }}%;
                                    min-height: 2px;
                                    background-color: {{ $barColor }};">
                        </div>
                        {{-- ツールチップ --}}
                        @if($day['count'] > 0)
                            <div class="absolute bottom-full mb-6 hidden group-hover:block bg-gray-800 text-white text-xs rounded px-1.5 py-0.5 whitespace-nowrap z-10">
                                {{ $day['label'] }}: {{ $day['count'] }}問 / 正答率{{ $day['count'] > 0 ? round($day['correct'] / $day['count'] * 100) : 0 }}%
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between text-xs text-gray-400 mt-1">
                <span>{{ $graphData[0]['label'] ?? '' }}</span>
                <span>{{ $graphData[count($graphData)-1]['label'] ?? '' }}</span>
            </div>
        </div>
    </div>

    {{-- 履歴テーブル --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-700">
                クイズ解答履歴
                @if($selectedDate)
                    <span class="ml-2 text-xs text-indigo-600">{{ $selectedDate }}</span>
                @endif
            </h2>
            @if($selectedDate)
                <a href="{{ route('history.index') }}" class="text-xs text-gray-400 hover:text-gray-600">× 絞り込み解除</a>
            @endif
        </div>

        @if($histories->count() > 0)
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500">
                    <tr>
                        <th class="text-left px-4 py-2">単語</th>
                        <th class="text-left px-4 py-2 hidden sm:table-cell">カテゴリ</th>
                        <th class="text-left px-4 py-2">結果</th>
                        <th class="text-left px-4 py-2 hidden sm:table-cell">解答日時</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($histories as $history)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium text-gray-800">
                                <a href="{{ route('words.show', $history->word) }}"
                                   class="hover:text-indigo-600">{{ $history->word->term }}</a>
                            </td>
                            <td class="px-4 py-2 text-gray-500 hidden sm:table-cell">{{ $history->word->section }}</td>
                            <td class="px-4 py-2">
                                <span class="text-xs px-2 py-0.5 rounded-full
                                    {{ $history->is_correct ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    {{ $history->is_correct ? '正解' : '不正解' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-gray-400 text-xs hidden sm:table-cell">
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
                <p class="text-sm">
                    @if($selectedDate)
                        {{ $selectedDate }}の解答履歴はありません。
                    @else
                        まだクイズの解答履歴がありません。
                    @endif
                </p>
                <a href="{{ route('quiz.index') }}"
                   class="mt-3 inline-block text-xs text-indigo-600 hover:underline">クイズに挑戦する</a>
            </div>
        @endif
    </div>

</x-sidebar>