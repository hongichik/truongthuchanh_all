{{-- Sử dụng helper trong view --}}
@php
use App\Helpers\CategoryDisplayHelper;
$homepageCategories = CategoryDisplayHelper::getHomepageCategories();
@endphp

@if(CategoryDisplayHelper::shouldShowCategories() && count($homepageCategories) > 0)
    <div class="homepage-categories">
        @foreach($homepageCategories as $categoryData)
            @php
                $config = $categoryData['config'];
                $category = $categoryData['category'];
                $articles = $categoryData['articles'];
            @endphp
            
            <div class="category-section mb-5" data-order="{{ $config['display_order'] }}">
                <div class="category-header d-flex justify-content-between align-items-center mb-3">
                    <h3 class="category-title">
                        <i class="fas fa-tags"></i> {{ $config['category_name'] }}
                    </h3>
                    @if($category)
                        <a href="{{ route('category.show', $category->slug) }}" class="btn btn-outline-primary btn-sm">
                            Xem tất cả <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
                </div>
                
                @if(count($articles) > 0)
                    <div class="row">
                        @foreach($articles as $article)
                            <div class="col-md-{{ 12 / min($config['posts_limit'], 4) }}">
                                <div class="article-card card mb-3">
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                             class="card-img-top" alt="{{ $article->title }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('article.show', [$article->category->slug, $article->slug]) }}">
                                                {{ $article->title }}
                                                @if($article->is_featured && $config['show_featured_only'])
                                                    <span class="badge bg-warning">Nổi bật</span>
                                                @endif
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted">{{ Str::limit($article->excerpt, 100) }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> {{ $article->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Chưa có bài viết nào trong danh mục này.
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif