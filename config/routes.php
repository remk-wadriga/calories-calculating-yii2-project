<?php

return [
    /**
     * @ IndexController
     */
    'registration'                                                          => 'index/registration',
    'login'                                                                 => 'index/login',
    'logout'                                                                => 'index/logout',
    'error'                                                                 => 'index/error',
    '/'                                                                     => 'index/index',

    /**
     * @ ProductCategoryController
     */
    'product-category/create'                                               => 'product-category/create',
    'product-category/<id:\d+>/update'                                      => 'product-category/update',
    'product-category/<id:\d+>/delete'                                      => 'product-category/delete',
    'product-category/<id:\d+>'                                             => 'product-category/view',
    'product-categories'                                                    => 'product-category/list',

    /**
     * @ ProductController
     */
    'product/create'                                                        => 'product/create',
    'product/<id:\d+>/update'                                               => 'product/update',
    'product/<id:\d+>/delete'                                               => 'product/delete',
    'products-of-category/<categoryId:\d+>'                                 => 'product/category',
    'product/diary-category/<categoryId:\d+>'                               => 'product/diary-category',
    'product/<id:\d+>'                                                      => 'product/view',
    'products'                                                              => 'product/list',

    /**
     * @ RecipeCategoryController
     */
    'recipe-category/create'                                                => 'recipe-category/create',
    'recipe-category/<id:\d+>/update'                                       => 'recipe-category/update',
    'recipe-category/<id:\d+>/delete'                                       => 'recipe-category/delete',
    'recipe-category/<id:\d+>'                                              => 'recipe-category/view',
    'recipe-categories'                                                     => 'recipe-category/list',

    /**
     * @ RecipeController
     */
    'recipe/create'                                                         => 'recipe/create',
    'recipe/<id:\d+>/update'                                                => 'recipe/update',
    'recipe/<id:\d+>/delete'                                                => 'recipe/delete',
    'recipes-of-category/<categoryId:\d+>'                                  => 'recipe/category',
    'recipe/diary-category/<categoryId:\d+>'                                => 'recipe/diary-category',
    'recipe/<id:\d+>'                                                       => 'recipe/view',
    'recipes'                                                               => 'recipe/list',

    /**
     * @ PortionController
     */
    'portion/create'                                                        => 'portion/create',
    'portion/<id:\d+>/update'                                               => 'portion/update',
    'portion/<id:\d+>/delete'                                               => 'portion/delete',
    'portions-of-category/<categoryId:\d+>'                                 => 'portion/category',
    'portion/diary-category/<categoryId:\d+>'                               => 'portion/diary-category',
    'portion/<id:\d+>'                                                      => 'portion/view',
    'portions'                                                              => 'portion/list',

    /**
     * PortionCategoryController
     */
    'portion-categories'                                                    => 'portion-category/list',

    /**
     * @ DiaryController
     */
    'diary/create'                                                          => 'diary/create',
    'diary/<id:\d+>/update'                                                 => 'diary/update',
    'diary/<id:\d+>/delete'                                                 => 'diary/delete',
    'diary/<id:\d+>'                                                        => 'diary/view',
    'diary'                                                                 => 'diary/list',

    /**
     * @ WeekStatsController
     */
    'week-stats/write/<date:.*>'                                            => 'week-stats/create',
    'week-stats/<id:\d+>/update'                                            => 'week-stats/update',
    'week-stats/<id:\d+>'                                                   => 'week-stats/view',
    'week-stats'                                                            => 'week-stats/list',

    /**
     * @ AccountController
     */
    'account/update'                                                        => 'account/update',
    'account'                                                               => 'account/view',

    /**
     * @ PlanController
     */
    /*'plan/create'                                                           => 'plan/create',
    'plan/<id:\d+>/update'                                                  => 'plan/update',
    'plan/<id:\d+>/delete'                                                  => 'plan/delete',
    'plan/<id:\d+>'                                                         => 'plan/view',
    'plan-list'                                                             => 'plan/list',*/

    /**
     * @ MenuController
     */
    /*'menu/create'                                                           => 'menu/create',
    'menu/<id:\d+>/update'                                                  => 'menu/update',
    'menu/<id:\d+>/delete'                                                  => 'menu/delete',
    'menu/<id:\d+>'                                                         => 'menu/view',
    'menu-list'                                                             => 'menu/list',*/

    /**
     * @ TrainingCategoryController
     */
    'training-category/create'                                              => 'training-category/create',
    'training-category/<id:\d+>/update'                                     => 'training-category/update',
    'training-category/<id:\d+>/delete'                                     => 'training-category/delete',
    'training-category/<id:\d+>'                                            => 'training-category/view',
    'training-categories'                                                   => 'training-category/list',

    /**
     * @ TrainingController
     */
    'training/create'                                                       => 'training/create',
    'training/<id:\d+>/update'                                              => 'training/update',
    'training/<id:\d+>/delete'                                              => 'training/delete',
    'trainings-of-category/<categoryId:\d+>'                                => 'training/category',
    'training/<id:\d+>'                                                     => 'training/view',
    'trainings'                                                             => 'training/list',
];