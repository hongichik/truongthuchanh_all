<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tin tức chung',
                'slug' => 'tin-tuc-chung',
                'description' => 'Tin tức tổng hợp về hoạt động của trường',
                'color' => '#007bff',
                'sort_order' => 1,
                'status' => 'active'
            ],
            [
                'name' => 'Thông báo',
                'slug' => 'thong-bao',
                'description' => 'Các thông báo quan trọng từ nhà trường',
                'color' => '#ffc107',
                'sort_order' => 2,
                'status' => 'active'
            ],
            [
                'name' => 'Hoạt động học sinh',
                'slug' => 'hoat-dong-hoc-sinh',
                'description' => 'Tin tức về các hoạt động ngoại khóa, thi đua',
                'color' => '#28a745',
                'sort_order' => 3,
                'status' => 'active'
            ],
            [
                'name' => 'Tuyển sinh',
                'slug' => 'tuyen-sinh',
                'description' => 'Thông tin tuyển sinh các cấp học',
                'color' => '#dc3545',
                'sort_order' => 4,
                'status' => 'active'
            ],
            [
                'name' => 'Giáo dục',
                'slug' => 'giao-duc',
                'description' => 'Tin tức về phương pháp giáo dục, chương trình học',
                'color' => '#6f42c1',
                'sort_order' => 5,
                'status' => 'active'
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
