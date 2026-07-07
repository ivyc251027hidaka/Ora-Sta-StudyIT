<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Study IT') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">

        {{-- サイドバー --}}
        <aside class="w-48 bg-white border-r border-gray-200 flex flex-col py-4 px-3 fixed h-full">

            {{-- ロゴ --}}
            <div class="mb-6 px-2">
                <span class="text-lg font-bold text-indigo-600">Study IT</span>
                <p class="text-xs text-gray-400">Oracle Silver SQL</p>
            </div>

            {{-- ナビリンク --}}
            <nav class="flex flex-col gap-1 flex-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
                          {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span>🏠</span> ホーム
                </a>
                <a href="{{ route('words.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
                          {{ request()->routeIs('words.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span>📚</span> 単語一覧
                </a>
                <a href="{{ route('quiz.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
                          {{ request()->routeIs('quiz.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span>🧠</span> クイズ
                </a>
                <a href="{{ route('favorites.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
                          {{ request()->routeIs('favorites.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span>⭐</span> お気に入り
                </a>
                <a href="{{ route('history.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
                          {{ request()->routeIs('history.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span>📈</span> 学習履歴
                </a>

                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
                          {{ request()->routeIs('admin.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span>⚙️</span> 管理画面
                </a>
                @endif
            </nav>

            {{-- ログアウト --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-red-500 hover:bg-red-50">
                    <span>🚪</span> ログアウト
                </button>
            </form>
        </aside>

        {{-- メインコンテンツ --}}
        <div class="ml-48 flex-1 flex flex-col">

            {{-- トップバー --}}
            <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center">
                <h1 class="text-lg font-semibold text-gray-800">{{ $title ?? 'ダッシュボード' }}</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    <a href="{{ route('profile.edit') }}"
                       class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-content text-indigo-700 text-sm font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </a>
                </div>
            </header>

            {{-- ページ本体 --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>