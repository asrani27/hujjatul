@if ($paginator->hasPages())
<nav aria-label="Page navigation">
    <ul class="flex justify-center items-center -space-x-px gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li>
            <span
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
                &laquo;
            </span>
        </li>
        @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-l-lg transition-colors">
                &laquo;
            </a>
        </li>
        @endif


        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li>
            <span
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                {{ $element }}
            </span>
        </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li>
            <span aria-current="page"
                class="relative inline-flex items-center px-3 py-2 text-sm font-bold text-white bg-indigo-600 border border-indigo-600">
                {{ $page }}
            </span>
        </li>
        @else
        <li>
            <a href="{{ $url }}"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                {{ $page }}
            </a>
        </li>
        @endif

        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-r-lg transition-colors">
                &raquo;
            </a>
        </li>
        @else

        <li>
            <span
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed">
                &raquo;
            </span>
        </li>
        @endif
    </ul>

    {{-- Info Text --}}
    <div class="mt-4 text-center text-sm text-gray-500">
        Menampilkan <span class="font-medium">{{ $paginator->firstItem() }}</span>
        sampai <span class="font-medium">{{ $paginator->lastItem() }}</span>
        dari <span class="font-medium">{{ $paginator->total() }}</span> data
    </div>
</nav>
@endif