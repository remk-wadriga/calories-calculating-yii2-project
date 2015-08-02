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
    'product-category/create'                                               => 'product-category/create',
    'product-category/<id:\d+>/update'                                      => 'product-category/update',
    'product-category/<id:\d+>/delete'                                      => 'product-category/delete',
    'product-category/<id:\d+>'                                             => 'product-category/view',
    'product-categories'                                                    => 'product-category/list',

    /**
     * @ ProductController controller
     */
    'product/create'                                                        => 'product/create',
    'product/<id:\d+>/update'                                               => 'product/update',
    'product/<id:\d+>/delete'                                               => 'product/delete',
    'products-of-category/<categoryId:\d+>'                                 => 'product/category',
    'product/diary-category/<categoryId:\d+>'                               => 'product/diary-category',
    'product/<id:\d+>'                                                      => 'product/view',
    'products'                                                              => 'product/list',

    /**
     * @ RecipeCategoryController controller
     */
    'recipe-category/create'                                                => 'recipe-category/create',
    'recipe-category/<id:\d+>/update'                                       => 'recipe-category/update',
    'recipe-category/<id:\d+>/delete'                                       => 'recipe-category/delete',
    'recipe-category/<id:\d+>'                                              => 'recipe-category/view',
    'recipe-categories'                                                     => 'recipe-category/list',

    /**
     * @ RecipeController controller
     */
    'recipe/create'                                                         => 'recipe/create',
    'recipe/<id:\d+>/update'                                                => 'recipe/update',
    'recipe/<id:\d+>/delete'                                                => 'recipe/delete',
    'recipes-of-category/<categoryId:\d+>'                                  => 'recipe/category',
    'recipe/diary-category/<categoryId:\d+>'                                => 'recipe/diary-category',
    'recipe/<id:\d+>'                                                       => 'recipe/view',
    'recipes'                                                               => 'recipe/list',

    /**
     * @ PortionController controller
     */
    'portion/create'                                                        => 'portion/create',
    'portion/<id:\d+>/update'                                               => 'portion/update',
    'portion/<id:\d+>/delete'                                               => 'portion/delete',
    'portions-of-category/<categoryId:\d+>'                                 => 'portion/category',
    'portion/diary-category/<categoryId:\d+>'                               => 'portion/diary-category',
    'portion/<id:\d+>'                                                      => 'portion/view',
    'portions'                                                              => 'portion/list',

    /**
     * PortionCategoryController controller
     */
    'portion-categories'                                                    => 'portion-category/list',

    /**
     * @ DiaryCotroller controller
     */
    'diary/create'                                                          => 'diary/create',
    'diary/<id:\d+>/update'                                                 => 'diary/update',
    'diary/<id:\d+>/delete'                                                 => 'diary/delete',
    'diary/<id:\d+>'                                                        => 'diary/view',
    'diary'                                                                 => 'diary/list',

    /**
     * @ WeekStatsController controller
     */
    'week-stats/write/<date:.*>'                                            => 'week-stats/create',
    'week-stats/<id:\d+>/update'                                            => 'week-stats/update',
    'week-stats/<id:\d+>'                                                   => 'week-stats/view',
    'week-stats'                                                            => 'week-stats/list',

    /**
     * @ AccountController controller
     */
    'account/update'                                                        => 'account/update',
    'account'                                                               => 'account/view',

    /**
     * @ PlanController controller
     */
    'plan/<id:\d+>/update'                                                  => 'plan/update',
    'plan/<id:\d+>/delete'                                                  => 'plan/delete',
    'plan/<id:\d+>'                                                         => 'plan/view',
    'plan-list'                                                             => 'plan/list',

    /**
     * @ MenuController controller
     */
    'menu/<id:\d+>/update'                                                  => 'menu/update',
    'menu/<id:\d+>/delete'                                                  => 'menu/delete',
    'menu/<id:\d+>'                                                         => 'menu/view',
    'menu-list'                                                             => 'menu/list',
];