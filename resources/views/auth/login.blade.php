<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン — Study IT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">

        {{-- 左エリア：ブランディング --}}
        <div class="hidden lg:flex w-1/2 bg-indigo-900 flex-col justify-center px-16 text-white">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Study IT</h1>
                <p class="text-indigo-300 text-sm">Oracle Silver SQL 学習アプリ</p>
            </div>
            <p class="text-indigo-200 text-sm leading-relaxed mb-8">
                SQL用語の暗記・クイズ・お気に入り管理で<br>Oracle Silver SQL合格を目指しましょう。
            </p>
            <div class="bg-indigo-800 rounded-xl p-4 font-mono text-xs text-green-400">
                <p class="text-indigo-400 mb-2">-- Oracle Silver SQL</p>
                <p>SELECT term, description</p>
                <p>FROM words</p>
                <p>WHERE difficulty = 'normal'</p>
                <p>ORDER BY section;</p>
            </div>
        </div>

        {{-- 右エリア：ログインフォーム --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 lg:px-16">
            <div class="max-w-md w-full mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">ログイン</h2>
                <p class="text-sm text-gray-500 mb-8">アカウントにサインインしてください。</p>

                {{-- セッションステータス --}}
                @if (session('status'))
                    <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- メールアドレス --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">メールアドレス</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                               placeholder="example@email.com">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- パスワード --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">パスワード</label>
                        <input type="password" name="password" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                               placeholder="パスワードを入力">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ログイン状態を保存 --}}
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="remember" class="rounded">
                            ログイン状態を保存
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-indigo-600 hover:underline">パスワードを忘れた方</a>
                        @endif
                    </div>

                    <button type="submit"
                            class="w-full bg-indigo-600 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                        ログイン
                    </button>
                </form>

                <p class="text-center text-sm text-gray-500 mt-6">
                    アカウントをお持ちでない方は
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">新規登録</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>