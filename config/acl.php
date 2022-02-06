<?php
//ACCESS CONTROL LIST PATTERNS
return [
    'config' => [
        'policy_ownership_enabled' => false,
        'max_super_admin_accounts' => 1,
    ],
    'default_roles' => [
        ['super_admin', 'Sales Agent', ]
    ],
    'permissions' => [
        'modules' => [
            // Maintenance Schedule
            [
                'name'          => 'maintenance_schedule.view',
                'guard_name'    => 'web',
                'key'           => 'maintenance_schedule_view',
                'module'        => 'Maintenance Management',
                'label'         => 'Maintenance Schedule',
                'description'   => 'Can view all maintenance schedules',
                'group'         => 'Maintenance Schedule'
            ],
            [
                'name'          => 'maintenance_schedule.create',
                'guard_name'    => 'web',
                'key'           => 'maintenance_schedule_create',
                'module'        => 'Maintenance Management',
                'label'         => 'Add New Schedule for Maintenance',
                'description'   => 'Can create new maintenance schedules',
                'group'         => 'Maintenance Schedule'
            ],
            [
                'name'          => 'maintenance_schedule.update',
                'guard_name'    => 'web',
                'key'           => 'maintenance_schedule_update',
                'module'        => 'Maintenance Management',
                'label'         => 'Update any Maintenance Schedule',
                'description'   => 'Can update any maintenance schedules',
                'group'         => 'Maintenance Schedule'
            ],
            [
                'name'          => 'maintenance_schedule.delete',
                'guard_name'    => 'web',
                'key'           => 'maintenance_schedule_delete',
                'module'        => 'Maintenance Management',
                'label'         => 'Delete any Maintenance Schedule',
                'description'   => 'Can delete any maintenance schedules',
                'group'         => 'Maintenance Schedule'
            ],
            [
                'name'          => 'maintenance_schedule.restore',
                'guard_name'    => 'web',
                'key'           => 'maintenance_schedule_restore',
                'module'        => 'Maintenance Management',
                'label'         => 'Restore any Maintenance Schedule',
                'description'   => 'Can restore any maintenance schedules',
                'group'         => 'Maintenance Schedule'
            ],
            [
                'name'          => 'maintenance_schedule.force_delete',
                'guard_name'    => 'web',
                'key'           => 'maintenance_schedule_force_delete',
                'module'        => 'Maintenance Management',
                'label'         => 'Force delete any Maintenance Schedule',
                'description'   => 'Can force delete any maintenance schedules',
                'group'         => 'Maintenance Schedule'
            ],

            // User Accounts
            [
                'name'          => 'user_account.view',
                'guard_name'    => 'web',
                'key'           => 'user_account_view',
                'module'        => 'User Management',
                'label'         => 'User Account',
                'description'   => 'Can view all user accounts',
                'group'         => 'User Accounts'
            ],
            [
                'name'          => 'user_account.create',
                'guard_name'    => 'web',
                'key'           => 'user_account_create',
                'module'        => 'User Management',
                'label'         => 'Add New User Account',
                'description'   => 'Can create new user accounts',
                'group'         => 'User Accounts'
            ],
            [
                'name'          => 'user_account.update',
                'guard_name'    => 'web',
                'key'           => 'user_account_update',
                'module'        => 'User Management',
                'label'         => 'Update any User Account',
                'description'   => 'Can update any user accounts',
                'group'         => 'User Accounts'
            ],
            [
                'name'          => 'user_account.delete',
                'guard_name'    => 'web',
                'key'           => 'user_account_delete',
                'module'        => 'User Management',
                'label'         => 'Delete any User Account',
                'description'   => 'Can delete any user accounts',
                'group'         => 'User Accounts'
            ],
            [
                'name'          => 'user_account.restore',
                'guard_name'    => 'web',
                'key'           => 'user_account_restore',
                'module'        => 'User Management',
                'label'         => 'Restore any User Account',
                'description'   => 'Can restore any user accounts',
                'group'         => 'User Accounts'
            ],
            [
                'name'          => 'user_account.force_delete',
                'guard_name'    => 'web',
                'key'           => 'user_account_force_delete',
                'module'        => 'User Management',
                'label'         => 'Force delete any User Account',
                'description'   => 'Can force delete any user accounts',
                'group'         => 'User Accounts'
            ],

            // Roles and Permissions
            [
                'name'          => 'role_and_permission.view',
                'guard_name'    => 'web',
                'key'           => 'role_and_permission_view',
                'module'        => 'User Management',
                'label'         => 'Roles and Permissions',
                'description'   => 'Can view all roles and permissions',
                'group'         => 'Roles and Permissions'
            ],
            [
                'name'          => 'role_and_permission.create',
                'guard_name'    => 'web',
                'key'           => 'role_and_permission_create',
                'module'        => 'User Management',
                'label'         => 'Add New Roles and Permission',
                'description'   => 'Can create new roles and permissions',
                'group'         => 'Roles and Permissions'
            ],
            [
                'name'          => 'role_and_permission.update',
                'guard_name'    => 'web',
                'key'           => 'role_and_permission_update',
                'module'        => 'User Management',
                'label'         => 'Update any Roles and Permissions',
                'description'   => 'Can update any roles and permissions',
                'group'         => 'Roles and Permissions'
            ],
            [
                'name'          => 'role_and_permission.delete',
                'guard_name'    => 'web',
                'key'           => 'role_and_permission_delete',
                'module'        => 'User Management',
                'label'         => 'Delete any Roles and Permissions',
                'description'   => 'Can delete any roles and permissions',
                'group'         => 'Roles and Permissions'
            ],
            [
                'name'          => 'role_and_permission.restore',
                'guard_name'    => 'web',
                'key'           => 'role_and_permission_restore',
                'module'        => 'User Management',
                'label'         => 'Restore any Roles and Permissions',
                'description'   => 'Can restore any roles and permissions',
                'group'         => 'Roles and Permissions'
            ],
            [
                'name'          => 'role_and_permission.force_delete',
                'guard_name'    => 'web',
                'key'           => 'role_and_permission_force_delete',
                'module'        => 'User Management',
                'label'         => 'Force delete any Roles and Permissions',
                'description'   => 'Can force delete any roles and permissions',
                'group'         => 'Roles and Permissions'
            ],

            // User Groups
            [
                'name'          => 'user_group.view',
                'guard_name'    => 'web',
                'key'           => 'user_group_view',
                'module'        => 'User Management',
                'label'         => 'User Groups',
                'description'   => 'Can view all user groups',
                'group'         => 'User Groups'
            ],
            [
                'name'          => 'user_group.create',
                'guard_name'    => 'web',
                'key'           => 'user_group_create',
                'module'        => 'User Management',
                'label'         => 'Add New User Group',
                'description'   => 'Can create new user groups',
                'group'         => 'User Groups'
            ],
            [
                'name'          => 'user_group.update',
                'guard_name'    => 'web',
                'key'           => 'user_group_update',
                'module'        => 'User Management',
                'label'         => 'Update any User Groups',
                'description'   => 'Can update any user groups',
                'group'         => 'User Groups'
            ],
            [
                'name'          => 'user_group.delete',
                'guard_name'    => 'web',
                'key'           => 'user_group_delete',
                'module'        => 'User Management',
                'label'         => 'Delete any User Groups',
                'description'   => 'Can delete any user groups',
                'group'         => 'User Groups'
            ],
            [
                'name'          => 'user_group.restore',
                'guard_name'    => 'web',
                'key'           => 'user_group_restore',
                'module'        => 'User Management',
                'label'         => 'Restore any User Groups',
                'description'   => 'Can restore any user groups',
                'group'         => 'User Groups'
            ],
            [
                'name'          => 'user_group.force_delete',
                'guard_name'    => 'web',
                'key'           => 'user_group_force_delete',
                'module'        => 'User Management',
                'label'         => 'Force delete any User Groups',
                'description'   => 'Can force delete any user groups',
                'group'         => 'User Groups'
            ],

            // FE Dashboard
            [
                'name'          => 'fe_dashboard',
                'guard_name'    => 'web',
                'key'           => 'fe_dashboard',
                'module'        => 'Front-End Payments',
                'label'         => 'FE Dashboard',
                'description'   => 'Can access Front-End Payment dashboard',
                'group'         => 'FE Dashboard'
            ],

            // FE Phone Sales
            [
                'name'          => 'fe_phone_sales',
                'guard_name'    => 'web',
                'key'           => 'fe_phone_sales',
                'module'        => 'Front-End Payments',
                'label'         => 'Phone Sales',
                'description'   => 'Can process phone sales',
                'group'         => 'Phone Sales'
            ],

            // Marketing Template
            [
                'name'          => 'marketing_template.view',
                'guard_name'    => 'web',
                'key'           => 'marketing_template_view',
                'module'        => 'Marketing',
                'label'         => 'Marekting Template',
                'description'   => 'Can view all marketing templates',
                'group'         => 'Marketing Template'
            ],
            [
                'name'          => 'marketing_template.create',
                'guard_name'    => 'web',
                'key'           => 'marketing_template_create',
                'module'        => 'Marketing',
                'label'         => 'Add New Marketing Template',
                'description'   => 'Can create new marketing templates',
                'group'         => 'Marketing Template'
            ],
            [
                'name'          => 'marketing_template.update',
                'guard_name'    => 'web',
                'key'           => 'marketing_template_update',
                'module'        => 'Marketing',
                'label'         => 'Update any Marketing Template',
                'description'   => 'Can update any marketing_templates',
                'group'         => 'Marketing Template'
            ],
            [
                'name'          => 'marketing_template.delete',
                'guard_name'    => 'web',
                'key'           => 'marketing_template_delete',
                'module'        => 'Marketing',
                'label'         => 'Delete any Marketing Template',
                'description'   => 'Can delete any marketing templates',
                'group'         => 'Marketing Template'
            ],
            [
                'name'          => 'marketing_template.restore',
                'guard_name'    => 'web',
                'key'           => 'marketing_template_restore',
                'module'        => 'Marketing',
                'label'         => 'Restore any Marketing Template',
                'description'   => 'Can restore any marketing templates',
                'group'         => 'Marketing Template'
            ],
            [
                'name'          => 'marketing_template.force_delete',
                'guard_name'    => 'web',
                'key'           => 'marketing_template_force_delete',
                'module'        => 'Marketing',
                'label'         => 'Force delete any Marketing Template',
                'description'   => 'Can force delete any marketing templates',
                'group'         => 'Marketing Template'
            ],

            // EverWebinar Pages
            [
                'name'          => 'everwebinar_page.view',
                'guard_name'    => 'web',
                'key'           => 'everwebinar_page_view',
                'module'        => 'Marketing',
                'label'         => 'EverWebinar Pages',
                'description'   => 'Can view all EverWebinar pages',
                'group'         => 'EverWebinar Pages'
            ],
            [
                'name'          => 'everwebinar_page.create',
                'guard_name'    => 'web',
                'key'           => 'everwebinar_page_create',
                'module'        => 'Marketing',
                'label'         => 'Add New EverWebinar Pages',
                'description'   => 'Can create new EverWebinar pages',
                'group'         => 'EverWebinar Pages'
            ],
            [
                'name'          => 'everwebinar_page.update',
                'guard_name'    => 'web',
                'key'           => 'everwebinar_page_update',
                'module'        => 'Marketing',
                'label'         => 'Update any EverWebinar Pages',
                'description'   => 'Can update any EverWebinar pages',
                'group'         => 'EverWebinar Pages'
            ],
            [
                'name'          => 'everwebinar_page.delete',
                'guard_name'    => 'web',
                'key'           => 'everwebinar_page_delete',
                'module'        => 'Marketing',
                'label'         => 'Delete any EverWebinar Pages',
                'description'   => 'Can delete any EverWebinar pages',
                'group'         => 'EverWebinar Pages'
            ],
            [
                'name'          => 'everwebinar_page.restore',
                'guard_name'    => 'web',
                'key'           => 'everwebinar_page_restore',
                'module'        => 'Marketing',
                'label'         => 'Restore any EverWebinar Pages',
                'description'   => 'Can restore any EverWebinar pages',
                'group'         => 'EverWebinar Pages'
            ],
            [
                'name'          => 'everwebinar_page.force_delete',
                'guard_name'    => 'web',
                'key'           => 'everwebinar_page_force_delete',
                'module'        => 'Marketing',
                'label'         => 'Force delete any EverWebinar Pages',
                'description'   => 'Can force delete any EverWebinar pages',
                'group'         => 'EverWebinar Pages'
            ],

            // Checkout Pages
            [
                'name'          => 'checkout_page.view',
                'guard_name'    => 'web',
                'key'           => 'checkout_page_view',
                'module'        => 'Marketing',
                'label'         => 'Checkout Pages',
                'description'   => 'Can view all Checkout pages',
                'group'         => 'Checkout Pages'
            ],
            [
                'name'          => 'checkout_page.create',
                'guard_name'    => 'web',
                'key'           => 'checkout_page_create',
                'module'        => 'Marketing',
                'label'         => 'Add New Checkout Pages',
                'description'   => 'Can create new Checkout pages',
                'group'         => 'Checkout Pages'
            ],
            [
                'name'          => 'checkout_page.update',
                'guard_name'    => 'web',
                'key'           => 'checkout_page_update',
                'module'        => 'Marketing',
                'label'         => 'Update any Checkout Pages',
                'description'   => 'Can update any Checkout pages',
                'group'         => 'Checkout Pages'
            ],
            [
                'name'          => 'checkout_page.delete',
                'guard_name'    => 'web',
                'key'           => 'checkout_page_delete',
                'module'        => 'Marketing',
                'label'         => 'Delete any Checkout Pages',
                'description'   => 'Can delete any Checkout pages',
                'group'         => 'Checkout Pages'
            ],
            [
                'name'          => 'checkout_page.restore',
                'guard_name'    => 'web',
                'key'           => 'checkout_page_restore',
                'module'        => 'Marketing',
                'label'         => 'Restore any Checkout Pages',
                'description'   => 'Can restore any Checkout pages',
                'group'         => 'Checkout Pages'
            ],
            [
                'name'          => 'checkout_page.force_delete',
                'guard_name'    => 'web',
                'key'           => 'checkout_page_force_delete',
                'module'        => 'Marketing',
                'label'         => 'Force delete any Checkout Pages',
                'description'   => 'Can force delete any Checkout pages',
                'group'         => 'Checkout Pages'
            ],

            // Customer LookUp
            [
                'name'          => 'customer_lookup.view',
                'guard_name'    => 'web',
                'key'           => 'customer_lookup_view',
                'module'        => 'Customer Service',
                'label'         => 'Customer LookUp',
                'description'   => 'Can view customer lookup',
                'group'         => 'Customer LookUp'
            ]
        ],
        'custom_permissions' => [
            [
                'name'          => '*.*,create,view,update,delete,restore,force_delete',
                'guard_name'    => 'web',
                'key'           => 'super_admin',
                'module'        => 'SYSTEM',
                'label'         => 'SUPER ADMIN',
                'description'   => 'SKY IS THE LIMIT',
                'group'         => ''
            ],
            [
                'name'          => 'profile.update',
                'guard_name'    => 'web',
                'key'           => 'profile_update',
                'module'        => 'Profile',
                'label'         => 'Update Profile',
                'description'   => 'Allow user to update profile(s) based on allowed Profile ID(s)',
                'group'         => 'Profile'
            ],
            [
                'name'          => 'have.custom.permissions',
                'guard_name'    => 'web',
                'key'           => 'have_custom_permissions',
                'module'        => '',
                'label'         => 'Have Custom Permission',
                'description'   => 'Allow user to have custom permissions',
                'group'         => ''
            ],
        ],
    ]
];
