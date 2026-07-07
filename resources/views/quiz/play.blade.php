<x-sidebar title="クイズに挑戦中">

    <div class="max-w-2xl">
        <div class="flex justify-between items-center mb-4">
            <span class="text-sm text-gray-500">問題 {{ $index + 1 }} / {{ $total }}</span>
            <a href="{{ route('quiz.index') }}"
               class="text-xs text-gray-400 hover:text-gray-600">× 中断して戻る</a>
        </div>

        {{-- 進捗バー --}}
        <div class="w-full bg-gray-100 rounded-full h-2 mb-6">
            <div class="bg-indigo-500 h-2 rounded-full transition-all"
                 style="width: {{ ($index / $total) * 100 }}%"></div>
        </div>

        {{-- 問題カード --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="mb-2">
                <span class="text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-700">{{ $word->section }}</span>
            </div>
            <p class="text-sm font-semibold text-gray-700 mb-2">次の説明に当てはまるSQL用語はどれですか？</p>
            <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ $word->description }}</p>

            @if($word->sql_example)
            <pre class="bg-gray-900 text-green-400 rounded-lg p-3 text-xs font-mono mb-4 overflow-x-auto">{{ $word->sql_example }}</pre>
            @endif

            {{-- 選択肢 --}}
            <form method="POST" action="{{ route('quiz.answer') }}">
                @csrf
                <div class="grid grid-cols-2 gap-3 mb-4">
                    @foreach($choices as $choice)
                        <label class="flex items-center gap-2 border border-gray-200 rounded-lg px-4 py-3 cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition">
                            <input type="radio" name="answer" value="{{ $choice }}" class="text-indigo-600" required>
                            <span class="text-sm text-gray-700">{{ $choice }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700">
                        次の問題へ →
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-sidebar>