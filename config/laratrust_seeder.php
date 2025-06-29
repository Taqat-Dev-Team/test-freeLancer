<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'clients' => 'c,r,u,d',
            'admins' => 'c,r,u,d',
            'free_lancers' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'sub_categories' => 'c,r,u,d',
            'freelancer_courses' => 'c,r,u,d',
            'freelancer_educations' => 'c,r,u,d',
            'freelancer_portfolios' => 'c,r,u,d',
            'freelancer_images' => 'c,r,u,d',
            'skills' => 'c,r,u,d',
            'logs' => 'r,d',
            'social_media' => 'c,r,u,d',
            'notifications' => 'c,r,u,d',
            'budges' => 'c,r,u,d',
            'projects' => 'c,r,u,d',
            'proposals' => 'c,r,u,d',
            'contacts' => 'r,u,d',
            'countries' => 'c,r,u,d',
            'educations' => 'c,r,u,d',

            'settings' => 'r,u',

        ],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
