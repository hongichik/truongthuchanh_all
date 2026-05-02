<?php

namespace App\Providers;

use App\Helpers\MenuHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share menu data with all views
        View::composer('*', function ($view) {
            // Skip admin views to avoid conflicts
            if (str_starts_with($view->getName(), 'admin.')) {
                return;
            }
            
            try {
                $headerMenus = MenuHelper::getMenusByPosition('header');
                $footerMenus = MenuHelper::getMenusByPosition('footer');
                $sidebarMenus = MenuHelper::getMenusByPosition('sidebar');
                
                $view->with([
                    'headerMenus' => $headerMenus,
                    'footerMenus' => $footerMenus,
                    'sidebarMenus' => $sidebarMenus
                ]);
            } catch (\Exception $e) {
                // Silent fail in case of database issues during migration
                $view->with([
                    'headerMenus' => collect(),
                    'footerMenus' => collect(),
                    'sidebarMenus' => collect()
                ]);
            }
        });

        // Specific view composers for layout files
        View::composer(['layouts.app', 'layouts.layout-master'], function ($view) {
            try {
                $view->with([
                    'headerMenuHtml' => MenuHelper::renderMenu(
                        MenuHelper::getMenusByPosition('header'),
                        [
                            'container_class' => 'navbar-nav me-auto mb-2 mb-lg-0',
                            'item_class' => 'nav-item',
                            'link_class' => 'nav-link',
                            'dropdown_class' => 'dropdown',
                            'dropdown_menu_class' => 'dropdown-menu',
                            'dropdown_item_class' => 'dropdown-item',
                            'has_dropdown_class' => 'dropdown-toggle'
                        ]
                    ),
                    'footerMenuHtml' => MenuHelper::renderMenu(
                        MenuHelper::getMenusByPosition('footer'),
                        [
                            'container_class' => 'list-unstyled d-flex flex-wrap',
                            'item_class' => 'me-3 mb-2',
                            'link_class' => 'text-light text-decoration-none',
                            'show_icon' => false
                        ]
                    )
                ]);
            } catch (\Exception $e) {
                $view->with([
                    'headerMenuHtml' => '',
                    'footerMenuHtml' => ''
                ]);
            }
        });
    }
}
