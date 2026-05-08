<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\HomeSetting;

class WebsiteConfigComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $settings = HomeSetting::current();
        
        $websiteConfig = [
            'header_image' => [
                'current' => $settings->header_image ?? 'bg_header.jpg',
                'path' => 'assets/image/',
            ],
            'logo' => [
                'current' => $settings->logo ?? 'logo.png',
                'path' => 'assets/image/',
            ],
            'contact_info' => $settings->contact_info ?? [
                'phone' => '0976.690.595-0982.972.709',
                'email' => 'thuchanh@uhl.edu.vn',
                'address' => 'Số 258, đường Bạch Đằng, phường Vàng Danh, tỉnh Quảng Ninh'
            ],
            'school_info' => $settings->school_info ?? [
                'name' => 'TRƯỜNG TH, THCS VÀ THPT THỰC HÀNH SƯ PHẠM',
                'parent_organization' => 'TRƯỜNG ĐẠI HỌC HẠ LONG',
                'short_description' => 'Nơi ươm mầm tương lai'
            ],
            'social_links' => $settings->social_links ?? [
                'facebook' => '',
                'youtube' => '',
                'website' => ''
            ]
        ];
        
        $view->with('websiteConfig', $websiteConfig);
    }
}