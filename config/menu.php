<?php

return [
    // [
    //     'bigId' => 'Ecommerce',
    //     'bigLabel' => 'Bán hàng',
    //     'icon' => 'shopping_basket',
    //     'bigItem' => [
    //         [
    //             'bigId' => 'Category',
    //             'can' => 'category.list',
    //             'icon' => 'category',
    //             'label' => 'Danh mục',
    //             'item' => [
    //                 [
    //                     'smallLabel' => 'Thêm mới',
    //                     'can' => 'category.create',
    //                     'route' => 'category.create'
    //                 ],
    //                 [
    //                     'smallLabel' => 'Danh sách',
    //                     'can' => 'category.list',
    //                     'route' => 'category'
    //                 ]
    //             ]
    //         ],
    //         [
    //             'bigId' => 'Product',
    //             'can' => 'product.list',
    //             'icon' => 'production_quantity_limits',
    //             'label' => 'Sản phẩm',
    //             'item' => [
    //                 [
    //                     'smallLabel' => 'Thêm mới',
    //                     'can' => 'product.create',
    //                     'route' => 'product.create'
    //                 ],
    //                 [
    //                     'smallLabel' => 'Danh sách',
    //                     'can' => 'product.list',
    //                     'route' => 'product'
    //                 ]
    //             ]
    //         ]
    //     ],
    // ],
    [
        'bigId' => 'Authentication',
        'bigLabel' => 'Hệ thống',
        'icon' => 'content_paste',
        'bigItem' => [
            [
                'bigId' => 'User',
                'can' => 'user.list',
                'icon' => 'person',
                'label' => 'Người dùng',
                'item' => [
                    [
                        'smallLabel' => 'Thêm mới',
                        'can' => 'user.create',
                        'route' => 'user.create'
                    ],
                    [
                        'smallLabel' => 'Danh sách',
                        'can' => 'user.list',
                        'route' => 'user'
                    ]
                ]
            ],
            [
                'bigId' => 'Role',
                'can' => 'role.list',
                'icon' => 'group',
                'label' => 'Vai trò',
                'item' => [
                    [
                        'smallLabel' => 'Thêm mới',
                        'can' => 'role.create',
                        'route' => 'role.create'
                    ],
                    [
                        'smallLabel' => 'Danh sách',
                        'can' => 'role.list',
                        'route' => 'role'
                    ]
                ]
            ],
            [
                'bigId' => 'Permission',
                'can' => 'permission.list',
                'icon' => 'privacy_tip',
                'label' => 'Quyền',
                'item' => [
                    [
                        'smallLabel' => 'Thêm mới',
                        'can' => 'permission.create',
                        'route' => 'permission.create'
                    ],
                    [
                        'smallLabel' => 'Danh sách',
                        'can' => 'permission.list',
                        'route' => 'permission'
                    ]
                ]
            ],
        ],
    ]
];
