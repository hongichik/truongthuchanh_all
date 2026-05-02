<?php

namespace App\Helpers;

use App\Models\Menu;

class MenuHelper
{
    /**
     * Lấy menu theo vị trí (header, footer, sidebar)
     */
    public static function getMenusByPosition($position = 'header')
    {
        return Menu::with(['children' => function($query) {
            $query->active()->ordered();
        }])
        ->byPosition($position)
        ->active()
        ->root()
        ->ordered()
        ->get();
    }

    /**
     * Render menu HTML
     */
    public static function renderMenu($menus, $options = [])
    {
        $defaults = [
            'container_class' => 'nav navbar-nav',
            'item_class' => 'nav-item',
            'link_class' => 'nav-link',
            'dropdown_class' => 'dropdown',
            'dropdown_menu_class' => 'dropdown-menu',
            'dropdown_item_class' => 'dropdown-item',
            'has_dropdown_class' => 'dropdown-toggle',
            'show_icon' => true
        ];
        
        $options = array_merge($defaults, $options);
        
        if ($menus->isEmpty()) {
            return '';
        }

        $html = '<ul class="' . $options['container_class'] . '">';
        
        foreach ($menus as $menu) {
            $html .= self::renderMenuItem($menu, $options);
        }
        
        $html .= '</ul>';
        
        return $html;
    }

    /**
     * Render từng menu item
     */
    private static function renderMenuItem($menu, $options, $level = 0)
    {
        $hasChildren = $menu->children->isNotEmpty();
        $itemClass = $options['item_class'];
        
        if ($hasChildren) {
            $itemClass .= ' ' . $options['dropdown_class'];
        }
        
        $html = '<li class="' . $itemClass . '">';
        
        // Menu link
        if ($menu->url) {
            $linkClass = $options['link_class'];
            if ($hasChildren) {
                $linkClass .= ' ' . $options['has_dropdown_class'];
            }
            
            $html .= '<a href="' . $menu->url . '" class="' . $linkClass . '" target="' . $menu->target . '"';
            
            if ($hasChildren) {
                $html .= ' data-bs-toggle="dropdown" aria-expanded="false"';
            }
            
            $html .= '>';
        } else {
            $html .= '<span class="' . $options['link_class'] . '">';
        }
        
        // Icon
        if ($options['show_icon'] && $menu->icon) {
            $html .= '<i class="' . $menu->icon . '"></i> ';
        }
        
        $html .= $menu->name;
        
        // Dropdown arrow
        if ($hasChildren) {
            $html .= ' <i class="fas fa-angle-down"></i>';
        }
        
        if ($menu->url) {
            $html .= '</a>';
        } else {
            $html .= '</span>';
        }
        
        // Children menu
        if ($hasChildren) {
            $html .= '<ul class="' . $options['dropdown_menu_class'] . '">';
            
            foreach ($menu->children as $child) {
                $html .= '<li>';
                $html .= '<a href="' . $child->url . '" class="' . $options['dropdown_item_class'] . '" target="' . $child->target . '">';
                
                if ($options['show_icon'] && $child->icon) {
                    $html .= '<i class="' . $child->icon . '"></i> ';
                }
                
                $html .= $child->name;
                $html .= '</a>';
                $html .= '</li>';
            }
            
            $html .= '</ul>';
        }
        
        $html .= '</li>';
        
        return $html;
    }

    /**
     * Render menu dạng cây (cho admin)
     */
    public static function renderMenuTree($menus, $level = 0)
    {
        $html = '';
        
        foreach ($menus as $menu) {
            $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
            $html .= '<option value="' . $menu->id . '">';
            $html .= $indent . ($level > 0 ? '└─ ' : '') . $menu->name;
            $html .= '</option>';
            
            if ($menu->children->isNotEmpty()) {
                $html .= self::renderMenuTree($menu->children, $level + 1);
            }
        }
        
        return $html;
    }

    /**
     * Lấy breadcrumb từ menu
     */
    public static function getBreadcrumb($currentUrl)
    {
        $menu = Menu::where('url', $currentUrl)->active()->first();
        
        if (!$menu) {
            return [];
        }
        
        return $menu->getFullPath();
    }

    /**
     * Kiểm tra menu có active không
     */
    public static function isMenuActive($menu, $currentUrl = null)
    {
        if (!$currentUrl) {
            $currentUrl = request()->getPathInfo();
        }
        
        if ($menu->url === $currentUrl) {
            return true;
        }
        
        // Kiểm tra menu con
        foreach ($menu->children as $child) {
            if ($child->url === $currentUrl) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Render menu cho mobile
     */
    public static function renderMobileMenu($menus)
    {
        if ($menus->isEmpty()) {
            return '';
        }

        $html = '<div class="mobile-menu">';
        
        foreach ($menus as $menu) {
            $html .= '<div class="mobile-menu-item">';
            
            if ($menu->url) {
                $html .= '<a href="' . $menu->url . '" target="' . $menu->target . '">';
            } else {
                $html .= '<span>';
            }
            
            if ($menu->icon) {
                $html .= '<i class="' . $menu->icon . '"></i> ';
            }
            
            $html .= $menu->name;
            
            if ($menu->url) {
                $html .= '</a>';
            } else {
                $html .= '</span>';
            }
            
            // Children menu
            if ($menu->children->isNotEmpty()) {
                $html .= '<div class="mobile-submenu">';
                
                foreach ($menu->children as $child) {
                    $html .= '<a href="' . $child->url . '" target="' . $child->target . '">';
                    
                    if ($child->icon) {
                        $html .= '<i class="' . $child->icon . '"></i> ';
                    }
                    
                    $html .= $child->name;
                    $html .= '</a>';
                }
                
                $html .= '</div>';
            }
            
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}