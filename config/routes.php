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
    'product-category/<id:\d+>/delete'                                      => 'product-category/delete',

    /**
     * @ ProductController controller
     */
    'products'                                                              => 'product/list',
    'product/<id:\d+>'                                                      => 'product/view',
    'product/create'                                                        => 'product/create',
    'product/<id:\d+>/update'                                               => 'product/update',
    'product/<id:\d+>/delete'                                               => 'product/delete',
    'products-of-category/<categoryId:\d+>'                                 => 'product/category',

    /**
     * @ RecipeCategoryController controller
     */
    'recipe-categories'                                                     => 'recipe-category/list',
    'recipe-category/<id:\d+>'                                              => 'recipe-category/view',
    'recipe-category/create'                                                => 'recipe-category/create',
    'recipe-category/<id:\d+>/update'                                       => 'recipe-category/update',
    'recipe-category/<id:\d+>/delete'                                       => 'recipe-category/delete',

    /**
     * @ RecipeController controller
     */
    'recipes'                                                               => 'recipe/list',
    'recipe/<id:\d+>'                                                       => 'recipe/view',
    'recipe/create'                                                         => 'recipe/create',
    'recipe/<id:\d+>/update'                                                => 'recipe/update',
    'recipe/<id:\d+>/delete'                                                => 'recipe/delete',
    'recipes-of-category/<categoryId:\d+>'                                  => 'recipe/category',

    /**
     * @ PortionController controller
     */
    'portions'                                                              => 'portion/list',
    'portion/<id:\d+>'                                                      => 'portion/view',
    'portion/create'                                                        => 'portion/create',
    'portion/<id:\d+>/update'                                               => 'portion/update',
    'portion/<id:\d+>/delete'                                               => 'portion/delete',
    'portions-of-category/<categoryId:\d+>'                                 => 'portion/category',

    /**
     * PortionCategoryController controller
     */
    'portion-categories'                                                    => 'portion-category/list',

    /**
     * DiaryCotroller controller
     */
    'diary'                                                                 => 'diary/list',
    'diary/<id:\d+>'                                                        => 'diary/view',
    'diary/create'                                                          => 'diary/create',
    'diary/<id:\d+>/update'                                                 => 'diary/update',
    'diary/<id:\d+>/delete'                                                 => 'diary/delete',
];