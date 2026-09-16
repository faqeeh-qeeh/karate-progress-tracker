@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col sm:flex-row items-center justify-between gap-3 text-slate-700">
        <!-- Results Summary Info -->
        <div class="text-xs text-slate-500 font-medium text-center sm:text-left">
            Menampilkan <span class="font-bold text-slate-900">{{ $paginator->firstItem() }}</span> sampai <span class="font-bold text-slate-900">{{ $paginator->lastItem() }}</span> dari <span class="font-bold text-slate-900">{{ $paginator->total() }}</span> data
        </div>

        <!-- Numbered Pagination Controls -->
        <div class="inline-flex items-center gap-1 flex-wrap justify-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 text-xs font-bold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed border border-slate-200">
                    &laquo; Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 hover:text-brand-primary rounded-xl transition border border-slate-200 shadow-xs">
                    &laquo; Prev
                </a>
            @endif

            {{-- Pagination Elements (Numbers & Ellipsis) --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-2 py-1.5 text-xs text-slate-400 font-extrabold select-none">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1.5 text-xs font-extrabold text-white bg-brand-primary rounded-xl shadow-xs border border-brand-primary">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 hover:text-brand-primary rounded-xl transition border border-slate-200 shadow-xs">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 hover:text-brand-primary rounded-xl transition border border-slate-200 shadow-xs">
                    Next &raquo;
                </a>
            @else
                <span class="px-3 py-1.5 text-xs font-bold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed border border-slate-200">
                    Next &raquo;
                </span>
            @endif
        </div>
    </nav>
@endif
