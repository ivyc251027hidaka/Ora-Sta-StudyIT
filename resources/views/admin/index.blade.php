<x-sidebar title="管理画面">

    {{-- フラッシュメッセージ --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- サマリーカード --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-1">総単語数</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $wordCount }} <span class="text-sm font-normal text-gray-400">語</span></p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <p class="text-xs text-gray-400 mb-1">登録ユーザー数</p>
            <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\User::count() }} <span class="text-sm font-normal text-gray-400">人</span></p>
        </div>
    </div>

    {{-- 単語管理テーブル --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex justify-between items-center px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">単語一覧</h2>
            <a href="{{ route('admin.words.create') }}"
               class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700">
                ＋ 単語を追加
            </a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500">
                <tr>
                    <th class="text-left px-4 py-2">単語名</th>
                    <th class="text-left px-4 py-2">カテゴリ</th>
                    <th class="text-left px-4 py-2">難易度</th>
                    <th class="text-left px-4 py-2">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($words as $word)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-800">{{ $word->term }}</td>
                        <td class="px-4 py-2 text-gray-500">{{ $word->section }}</td>
                        <td class="px-4 py-2">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $word->difficulty === 'easy' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $word->difficulty === 'normal' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $word->difficulty === 'hard' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $word->difficulty === 'easy' ? '易しい' : ($word->difficulty === 'normal' ? '普通' : '難しい') }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.words.edit', $word) }}"
                                   class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded hover:bg-gray-200">編集</a>
                                <form method="POST" action="{{ route('admin.words.destroy', $word) }}"
                                      onsubmit="return confirm('削除してもよいですか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded hover:bg-red-200">削除</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">
                            単語がまだ登録されていません。
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3 border-t border-gray-100">
            {{ $words->links() }}
        </div>
    </div>

</x-sidebar>