<?php

return [
    /**
     * @ Index controller
     */
    'registration'                                                          => 'index/registration',
    'login'                                                                 => 'index/login',
    'logout'                                                                => 'index/logout',
    'error'                                                                 => 'index/error',
    '/'                                                                     => 'index/index',

    /**
     * @ ProductCategoryController controller
     */
    'product-categories'                                                    => 'product-category/list',
    'product-category/<id:\d+>'                                             => 'product-category/view',
    'product-category/create'                                               => 'product-category/create',
    'product-category/<id:\d+>/update'                                      => 'product-category/update',

    /**
     * @ ProductController controller
     */
    'products'                                                              => 'product/list',
    'product/<id:\d+>'                                                      => 'product/view',
    'product/create'                                                        => 'product/create',
    'product/<id:\d+>/update'                                               => 'product/update',
    'products-of-category/<categoryId:\d+>'                                 => 'product/category',
];