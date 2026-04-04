<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sidebar Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the admin sidebar menu, icons, routes, and permissions.
    |
    */
    'sidebar' => [
        'brand' => [
            'text' => 'Master Admin',
            'logo' => 'vendor/master-admin/assets/img/logoIT.png',
            'logo_mini' => 'vendor/master-admin/assets/img/logoIT.png',
            'route' => 'master-admin.dashboard',
        ],
        'theme' => [
            'dark_mode' => false,
            'class' => 'bg-body-tertiary shadow',
        ],
        'menu' => [
            [
                'text' => 'Dashboard',
                'icon' => 'bi bi-speedometer',
                'route' => 'admin.dashboard',
                'active' => 'admin.dashboard',
            ],
            [
                'text' => 'Quản lý đơn nhập học',
                'icon' => 'fas fa-graduation-cap',
                'active' => 'admin/applications*',
                'submenu' => [
                    [
                        'text' => 'Tổng quan',
                        'icon' => 'fas fa-chart-pie',
                        'route' => 'admin.applications.index',
                        'active' => 'admin/applications',
                    ],
                    [
                        'text' => 'Đơn vào lớp 1',
                        'icon' => 'fas fa-child',
                        'route' => 'admin.applications.lop1',
                        'active' => 'admin/applications/lop-1',
                    ],
                    [
                        'text' => 'Đơn vào lớp 6',
                        'icon' => 'fas fa-user-graduate',
                        'route' => 'admin.applications.lop6',
                        'active' => 'admin/applications/lop-6*',
                    ],
                    [
                        'text' => 'Đơn vào lớp 10',
                        'icon' => 'fas fa-graduation-cap',
                        'route' => 'admin.applications.lop10',
                        'active' => 'admin/applications/lop-10*',
                    ],
                ],
            ],
            [
                'text' => 'Quản lý quản trị',
                'icon' => 'bi bi-shield-lock',
                'active' => 'admin/role*',
                'permission' => 'manage-permissions',
                'submenu' => [
                    [
                        'text' => 'Quyền',
                        'icon' => 'bi bi-key',
                        'route' => 'admin.role.permission.index',
                        'active' => 'admin/role/permission*',
                        'permission' => 'manage-permissions',
                    ],
                    [
                        'text' => 'Vai trò',
                        'icon' => 'bi bi-person-badge',
                        'route' => 'admin.role.role.index',
                        'active' => 'admin/role/role*',
                        'permission' => 'manage-roles',
                    ],
                    [
                        'text' => 'Quản trị viên',
                        'icon' => 'bi bi-people',
                        'route' => 'admin.role.admin.index',
                        'active' => 'admin/role/admin*',
                        'permission' => 'manage-admins',
                    ],
                ],
            ],
        ],
    ],
];
