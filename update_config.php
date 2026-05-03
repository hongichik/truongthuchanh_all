<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Create new configuration with requested categories
$newConfig = [
    [
        'is_visible' => true,
        'category_id' => 4, // Tuyển sinh
        'posts_limit' => 3,
        'category_name' => 'Tuyển sinh',
        'category_slug' => 'tuyen-sinh',
        'display_order' => 1,
        'show_featured_only' => false
    ],
    [
        'is_visible' => true,
        'category_id' => 3, // Hoạt động học sinh
        'posts_limit' => 3,
        'category_name' => 'Hoạt động học sinh',
        'category_slug' => 'hoat-dong-hoc-sinh',
        'display_order' => 2,
        'show_featured_only' => false
    ],
    [
        'is_visible' => true,
        'category_id' => 1, // Tin tức chung
        'posts_limit' => 3,
        'category_name' => 'Tin tức chung',
        'category_slug' => 'tin-tuc-chung',
        'display_order' => 3,
        'show_featured_only' => false
    ]
];

// Update or create home settings
$homeSetting = App\Models\HomeSetting::first();
if (!$homeSetting) {
    $homeSetting = new App\Models\HomeSetting();
}

$homeSetting->category_display_config = $newConfig;
$homeSetting->save();

echo "Updated homepage configuration successfully!\n";
echo "New config:\n";
echo json_encode($newConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";