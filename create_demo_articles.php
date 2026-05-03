<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Article;
use App\Models\Category;

// Get template article and category
$template = Article::where('slug', 'thu-nghiem-copy-copy-1777771805')->first();
$category = Category::find(1); // tin-tuc-chung

if (!$template) {
    echo "Template article not found!\n";
    exit(1);
}

if (!$category) {
    echo "Category not found!\n";
    exit(1);
}

echo "Creating 25 demo articles in category: {$category->name}\n";
echo "Template: {$template->title}\n\n";

$created = 0;

for ($i = 1; $i <= 25; $i++) {
    $title = "Bài viết demo số {$i} - {$category->name}";
    $slug = "bai-viet-demo-so-{$i}";
    
    // Check if article already exists
    if (Article::where('slug', $slug)->exists()) {
        echo "Skipped (exists): {$slug}\n";
        continue;
    }
    
    try {
        $article = Article::create([
            'title' => $title,
            'slug' => $slug,
            'description' => "Đây là bài viết demo số {$i} được tạo tự động để test phân trang. " . substr($template->description ?? '', 0, 100),
            'content' => "<h2>Bài viết demo số {$i}</h2>\n" . $template->content . "\n<p>Đây là nội dung mở rộng cho bài viết số {$i} nhằm mục đích kiểm tra tính năng phân trang của website.</p>",
            'category_id' => $category->id,
            'status' => 'published',
            'is_featured' => ($i % 5 == 0), // Every 5th article is featured
            'view_count' => rand(10, 500),
            'featured_image' => $template->featured_image,
            'tags' => "demo,test,phân trang,bài viết {$i}",
            'created_by' => 1, // Default admin user
            'published_at' => now()->subDays(rand(1, 30)),
            'created_at' => now()->subDays(rand(1, 30)),
            'updated_at' => now()->subDays(rand(1, 15)),
        ]);
        
        echo "Created: {$title}\n";
        $created++;
        
    } catch (Exception $e) {
        echo "Error creating article {$i}: " . $e->getMessage() . "\n";
    }
}

echo "\nDemo articles creation completed!\n";
echo "Created: {$created} articles\n";
echo "Total articles in category: " . Article::where('category_id', $category->id)->count() . "\n";