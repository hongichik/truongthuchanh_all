<?php

namespace App\Helpers;

class WebsiteHelper
{
    /**
     * Get website configuration value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function config($key, $default = null)
    {
        return config("website.{$key}", $default);
    }

    /**
     * Get website header image
     *
     * @return string
     */
    public static function getHeaderImage()
    {
        $imagePath = self::config('header_image.path', 'assets/image/');
        $imageName = self::config('header_image.current', 'bg_header_default.jpg');
        
        return asset($imagePath . $imageName);
    }

    /**
     * Get website logo
     *
     * @return string
     */
    public static function getLogo()
    {
        $logoPath = self::config('logo.path', 'assets/image/');
        $logoName = self::config('logo.current', 'logo_default.png');
        
        return asset($logoPath . $logoName);
    }

    /**
     * Get contact information
     *
     * @param string $type (phone, email, address)
     * @return string|null
     */
    public static function getContactInfo($type)
    {
        return self::config("contact_info.{$type}");
    }

    /**
     * Get school information
     *
     * @param string $type (name, parent_organization, short_description)
     * @return string|null
     */
    public static function getSchoolInfo($type)
    {
        return self::config("school_info.{$type}");
    }

    /**
     * Get social media links
     *
     * @param string $platform (facebook, youtube, website)
     * @return string|null
     */
    public static function getSocialLink($platform)
    {
        return self::config("social_links.{$platform}");
    }

    /**
     * Format Vietnamese phone number
     *
     * @param string $phone
     * @return string
     */
    public static function formatVietnamesePhone($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Format phone number if it's Vietnamese format
        if (strlen($phone) == 10 || strlen($phone) == 11) {
            if (strlen($phone) == 10) {
                return substr($phone, 0, 4) . '.' . substr($phone, 4, 3) . '.' . substr($phone, 7);
            } elseif (strlen($phone) == 11) {
                return substr($phone, 0, 4) . '.' . substr($phone, 4, 4) . '.' . substr($phone, 8);
            }
        }
        
        return $phone;
    }

    /**
     * Generate breadcrumb for pages
     *
     * @param array $breadcrumbs
     * @return string
     */
    public static function generateBreadcrumb($breadcrumbs = [])
    {
        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
        
        // Add home link
        $html .= '<li class="breadcrumb-item"><a href="/">Trang chủ</a></li>';
        
        foreach ($breadcrumbs as $item) {
            if (isset($item['url'])) {
                $html .= '<li class="breadcrumb-item"><a href="' . $item['url'] . '">' . $item['title'] . '</a></li>';
            } else {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . $item['title'] . '</li>';
            }
        }
        
        $html .= '</ol></nav>';
        
        return $html;
    }

    /**
     * Format date to Vietnamese format
     *
     * @param string|DateTime $date
     * @return string
     */
    public static function formatVietnameseDate($date)
    {
        if (!$date) {
            return '';
        }

        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        return $date->format('d/m/Y');
    }

    /**
     * Format datetime to Vietnamese format
     *
     * @param string|DateTime $datetime
     * @return string
     */
    public static function formatVietnameseDateTime($datetime)
    {
        if (!$datetime) {
            return '';
        }

        if (is_string($datetime)) {
            $datetime = new \DateTime($datetime);
        }

        return $datetime->format('d/m/Y H:i');
    }

    /**
     * Check if image file exists
     *
     * @param string $path
     * @return bool
     */
    public static function imageExists($path)
    {
        return file_exists(public_path($path));
    }

    /**
     * Get default image if the specified image doesn't exist
     *
     * @param string $imagePath
     * @param string $defaultImagePath
     * @return string
     */
    public static function getImageOrDefault($imagePath, $defaultImagePath = 'assets/image/default.jpg')
    {
        if (self::imageExists($imagePath)) {
            return asset($imagePath);
        }
        
        return asset($defaultImagePath);
    }
}