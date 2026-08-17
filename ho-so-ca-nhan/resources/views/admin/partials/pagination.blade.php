@if ($paginator->hasPages())
    @php
        $uniqueId = 'paginator_' . uniqid();
    @endphp
    <div class="admin-pagination-container" id="{{ $uniqueId }}">
        <!-- Info text -->
        <div style="font-size:13.5px; color:var(--text-secondary); font-weight:500;">
            Hiển thị {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} trong số {{ $paginator->total() }} hàng
        </div>

        <ul class="admin-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="admin-page-item disabled">
                    <span class="admin-page-link">‹</span>
                </li>
            @else
                <li class="admin-page-item">
                    <a class="admin-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="admin-page-item disabled"><span class="admin-page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="admin-page-item active">
                                <span class="admin-page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="admin-page-item">
                                <a class="admin-page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="admin-page-item">
                    <a class="admin-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">›</a>
                </li>
            @else
                <li class="admin-page-item disabled">
                    <span class="admin-page-link">›</span>
                </li>
            @endif
        </ul>

        <!-- Go to page input -->
        <div class="admin-page-go-to">
            <span>Đi tới trang</span>
            <input type="number" min="1" max="{{ $paginator->lastPage() }}" value="{{ $paginator->currentPage() }}" class="goto-page-num">
            <button type="button" class="admin-btn-go-to-page btn-goto-page">Đi</button>
        </div>
    </div>

    <script>
        (function() {
            const container = document.getElementById('{{ $uniqueId }}');
            if (!container) return;
            const btn = container.querySelector('.btn-goto-page');
            const input = container.querySelector('.goto-page-num');
            const maxPage = {{ $paginator->lastPage() }};

            const goToPage = function() {
                const pageNum = parseInt(input.value);
                if (pageNum >= 1 && pageNum <= maxPage) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('page', pageNum);
                    window.location.href = url.toString();
                } else {
                    alert('Vui lòng nhập số trang hợp lệ từ 1 đến ' + maxPage);
                }
            };

            btn?.addEventListener('click', goToPage);
            input?.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    goToPage();
                }
            });
        })();
    </script>
@endif
