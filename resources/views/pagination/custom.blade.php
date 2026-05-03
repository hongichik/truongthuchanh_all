@if ($paginator->hasPages())
    <div class="custom-pagination">
        <div class="pagination-container">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="page-btn disabled" aria-disabled="true">
                    <span class="arrow">‹</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-btn" rel="prev">
                    <span class="arrow">‹</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-btn disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-btn" rel="next">
                    <span class="arrow">›</span>
                </a>
            @else
                <span class="page-btn disabled" aria-disabled="true">
                    <span class="arrow">›</span>
                </span>
            @endif
        </div>
        
        <div class="pagination-info">
            Hiển thị {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} trong tổng số {{ $paginator->total() }} kết quả
        </div>
    </div>

    <style>
        .custom-pagination {
            text-align: center;
            margin-top: 40px;
            padding: 20px 0;
        }
        
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .page-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 8px 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            background: white;
            font-size: 14px;
            line-height: 1;
        }
        
        .page-btn:hover {
            border-color: #22c55e;
            color: #22c55e;
            background: #f0fdf4;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(34, 197, 94, 0.2);
        }
        
        .page-btn.active {
            background: #22c55e;
            border-color: #22c55e;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
        }
        
        .page-btn.disabled {
            color: #d1d5db;
            border-color: #f3f4f6;
            background: #f9fafb;
            cursor: not-allowed;
        }
        
        .page-btn.disabled:hover {
            transform: none;
            box-shadow: none;
            border-color: #f3f4f6;
            background: #f9fafb;
            color: #d1d5db;
        }
        
        .arrow {
            font-size: 18px;
            font-weight: bold;
        }
        
        .pagination-info {
            margin-top: 15px;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .pagination-container {
                gap: 4px;
            }
            
            .page-btn {
                min-width: 35px;
                height: 35px;
                font-size: 13px;
            }
            
            .pagination-info {
                font-size: 12px;
                margin-top: 10px;
            }
        }
    </style>
@endif