<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa tất cả menu cũ
        Menu::truncate();

        // Tạo menu chính theo structure từ HTML
        $trangChu = Menu::create([
            'name' => 'TRANG CHỦ',
            'slug' => 'trang-chu',
            'url' => '/',
            'sort_order' => 1,
            'status' => 'active',
            'position' => 'header',
            'icon' => 'fas fa-home',
            'target' => '_self'
        ]);

        // Menu Tuyển sinh với submenu
        $tuyenSinh = Menu::create([
            'name' => 'TUYỂN SINH',
            'slug' => 'tuyen-sinh',
            'url' => '#',
            'sort_order' => 2,
            'status' => 'active',
            'position' => 'header',
            'icon' => 'fas fa-clipboard-list',
            'target' => '_self'
        ]);

        Menu::create([
            'name' => 'Đăng ký vào lớp 10',
            'slug' => 'dang-ky-lop-10',
            'url' => '/dang-ky/lop-10',
            'parent_id' => $tuyenSinh->id,
            'sort_order' => 1,
            'status' => 'active',
            'position' => 'header',
            'icon' => 'fas fa-child',
            'target' => '_self'
        ]);

        Menu::create([
            'name' => 'Đăng ký vào lớp 6',
            'slug' => 'dang-ky-lop-6',
            'url' => '/dang-ky/lop-6',
            'parent_id' => $tuyenSinh->id,
            'sort_order' => 2,
            'status' => 'active',
            'position' => 'header',
            'icon' => 'fas fa-user-graduate',
            'target' => '_self'
        ]);

        Menu::create([
            'name' => 'Đăng ký vào lớp 1',
            'slug' => 'dang-ky-lop-1',
            'url' => '/dang-ky/lop-1',
            'parent_id' => $tuyenSinh->id,
            'sort_order' => 3,
            'status' => 'active',
            'position' => 'header',
            'icon' => 'fas fa-graduation-cap',
            'target' => '_self'
        ]);

        // Menu Tin tức
        Menu::create([
            'name' => 'TIN TỨC',
            'slug' => 'tin-tuc',
            'url' => '/tin-tuc',
            'sort_order' => 3,
            'status' => 'active',
            'position' => 'header',
            'icon' => 'fas fa-newspaper',
            'target' => '_self'
        ]);

        // Các menu khác
        Menu::create([
            'name' => 'GIỚI THIỆU TRƯỜNG',
            'slug' => 'gioi-thieu-truong',
            'url' => '/gioi-thieu',
            'sort_order' => 4,
            'status' => 'active',
            'position' => 'header',
            'target' => '_self'
        ]);

        Menu::create([
            'name' => 'CẤP TIỂU HỌC',
            'slug' => 'cap-tieu-hoc',
            'url' => '#',
            'sort_order' => 5,
            'status' => 'active',
            'position' => 'header',
            'target' => '_self'
        ]);

        Menu::create([
            'name' => 'CẤP THCS',
            'slug' => 'cap-thcs',
            'url' => '#',
            'sort_order' => 6,
            'status' => 'active',
            'position' => 'header',
            'target' => '_self'
        ]);

        Menu::create([
            'name' => 'CẤP THPT',
            'slug' => 'cap-thpt',
            'url' => '#',
            'sort_order' => 7,
            'status' => 'active',
            'position' => 'header',
            'target' => '_self'
        ]);

        Menu::create([
            'name' => 'LIÊN HỆ',
            'slug' => 'lien-he',
            'url' => '/lien-he',
            'sort_order' => 8,
            'status' => 'active',
            'position' => 'header',
            'target' => '_self'
        ]);
    }
}
