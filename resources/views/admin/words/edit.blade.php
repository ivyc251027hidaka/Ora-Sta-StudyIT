<x-sidebar title="単語を編集">

    <div class="max-w-2xl">
        <a href="{{ route('admin.index') }}"
           class="text-xs text-gray-500 hover:text-gray-700 mb-4 inline-block">← 管理画面に戻る</a>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="POST" action="{{ route('admin.words.update', $word) }}">
                @csrf
                @method('PUT')

                {{-- 単語名 --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">単語名 <span class="text-red-500">*</span></label>
                    <input type="text" name="term" value="{{ old('term', $word->term) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    @error('term')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- 説明文 --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">説明文 <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('description', $word->description) }}</textarea>
                    @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- カテゴリ・難易度 --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">カテゴリ <span class="text-red-500">*</span></label>
                        <input type="text" name="section" value="{{ old('section', $word->section) }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        @error('section')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">難易度 <span class="text-red-500">*</span></label>
                        <select name="difficulty"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            <option value="easy" {{ old('difficulty', $word->difficulty) == 'easy' ? 'selected' : '' }}>易しい</option>
                            <option value="normal" {{ old('difficulty', $word->difficulty) == 'normal' ? 'selected' : '' }}>普通</option>
                            <option value="hard" {{ old('difficulty', $word->difficulty) == 'hard' ? 'selected' : '' }}>難しい</option>
                        </select>
                    </div>
                </div>

                {{-- 出題形式 --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">出題形式 <span class="text-red-500">*</span></label>
                    <select name="quiz_type"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        <option value="choice" {{ old('quiz_type', $word->quiz_type) == 'choice' ? 'selected' : '' }}>4択</option>
                        <option value="written" {{ old('quiz_type', $word->quiz_type) == 'written' ? 'selected' : '' }}>記述</option>
                    </select>
                </div>

                {{-- SQL例 --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">SQL使用例</label>
                    <textarea name="sql_example" rows="4"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('sql_example', $word->sql_example) }}</textarea>
                </div>

                {{-- ボタン --}}
                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-indigo-700">更新</button>
                    <a href="{{ route('admin.index') }}"
                       class="bg-gray-100 text-gray-600 px-5 py-2 rounded-lg text-sm hover:bg-gray-200">キャンセル</a>
                </div>
            </form>
        </div>
    </div>

</x-sidebar>