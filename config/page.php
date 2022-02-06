<?php

return [
    'maintenance' => [
        'table_header' => [
            'id' => '#',
            'ticket_no' => 'Ticket No.',
            'message' => 'Message',
            'schedule_start' => 'Schedule Start',
            'schedule_end' => 'Schedule End',
            'is_active' => 'Status',
            'auto_up_on_schedule_end' => 'Auto Up',
            'created_at' => 'Date Created',
            'action_id' => 'Action',
        ],

        'index_title' => 'Maintenance Management',

        'view_title' => 'View List',

        'create_title' => 'Create New',

        'edit_title' => 'Edit Details',
    ],

    'marketing-journey' => [
      'table_header' => [
        'id' => '#',
        'subscription_name' => 'Subscription Name',
        'subscription_id' => 'Subscription ID',
        'url' => 'URL',
        'campaign_name' => 'Campaign Name',
        'campaign_id' => 'Campaign ID'
      ],

      'index_title' => 'Marketing Journey',

      'view_title' => 'View List',

      'create_title' => 'Create New',

      'edit_title' => 'Edit Details',
    ],

    'marketing-template' => [
        'table_header' => [
            'id' => '#',
            'name' => 'Template Name',
            'description' => 'Description',
            'service_name' => 'service name',
            'folder_name' => 'folder name'
        ],

        'index_title' => 'Marketing Template',

        'view_title' => 'View List',

        'create_title' => 'Create New',

        'edit_title' => 'Edit Details',
    ],

    'user' => [
        'table_header' => [
            'id' => '#',
            'name' => 'Name',
            'email' => 'Email',
            'is_active' => 'Status',
            'last_login_at' => 'Last Login At',
            'last_login_ip' => 'Last Login IP',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Updated',
            'action_id' => 'Action',
        ],

        'index_title' => 'User Management',

        'view_title' => 'View List',

        'create_title' => 'Create New',

        'edit_title' => 'Edit Details',
    ],

    'roles-management' => [
        'table_header' => [
            'id' => '#',
            'name' => 'Name',
            'guard_name' => 'Guard Name'
        ],

        'index_title' => 'Roles Management',

        'view_title' => 'View List',

        'create_title' => 'Create New',

        'edit_title' => 'Edit Details',
    ],


    'customer-service' => [
        'table_header' => [
            'id' => '#',
            'name' => 'Name',
            'guard_name' => 'Guard Name'
        ],

        'index_title' => 'Customer Service',

        'view_title' => 'View List',

        'create_title' => 'Create New',

        'edit_title' => 'Edit Details',
    ],

    'user-group' => [
        'table_header' => [
            'id' => '#',
            'name' => 'Group Name',
            'description' => 'Description',
            'is_active' => 'Status'
        ],

        'index_title' => 'User Group',

        'view_title' => 'View List',

        'create_title' => 'Create New',

        'edit_title' => 'Edit Details',
    ],
];
