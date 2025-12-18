<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Nomi',
    'column.guard_name' => 'Guard Nomi',
    'column.team' => 'Jamoa',
    'column.roles' => 'Rollar',
    'column.permissions' => 'Ruxsatlar',
    'column.updated_at' => 'Yangilangan',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Nomi',
    'field.guard_name' => 'Guard Nomi',
    'field.permissions' => 'Ruxsatlar',
    'field.team' => 'Jamoa',
    'field.team.placeholder' => 'Jamoani tanlang ...',
    'field.select_all.name' => 'Hammasini tanlash',
    'field.select_all.message' => 'Ushbu rol uchun barcha ruxsatlarni yoqish/o\'chirish',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Filament Shield',
    'nav.role.label' => 'Rollar',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Rol',
    'resource.label.roles' => 'Rollar',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Ob\'ektlar',
    'resources' => 'Resurslar',
    'widgets' => 'Vidjetlar',
    'pages' => 'Sahifalar',
    'custom' => 'Maxsus Ruxsatlar',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'Sizda kirish ruxsati yo\'q',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'Ko\'rish',
        'view_any' => 'Barchasini ko\'rish',
        'create' => 'Yaratish',
        'update' => 'Yangilash',
        'delete' => 'O\'chirish',
        'delete_any' => 'Barchasini o\'chirish',
        'force_delete' => 'Majburiy o\'chirish',
        'force_delete_any' => 'Barchasini majburiy o\'chirish',
        'restore' => 'Tiklash',
        'reorder' => 'Qayta tartiblash',
        'restore_any' => 'Barchasini tiklash',
        'replicate' => 'Nusxalash',
    ],
];
