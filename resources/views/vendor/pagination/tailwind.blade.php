@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-1 flex-wrap">
        {{-- 前へ --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 text-xs text-gray-300 bg-white border border-gray-200 rounded-lg cursor-not-allowed">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-1.5 text-xs text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-300 transition">←</a>
        @endif

        {{-- ページ番号 --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1.5 text-xs text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 text-xs text-white bg-indigo-600 border border-indigo-600 rounded-lg font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-1.5 text-xs text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-300 transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 次へ --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-1.5 text-xs text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-300 transition">→</a>
        @else
            <span class="px-3 py-1.5 text-xs text-gray-300 bg-white border border-gray-200 rounded-lg cursor-not-allowed">→</span>
        @endif
    </nav>
@endif