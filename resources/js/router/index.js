import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Dashboard from '../components/admin/DashboardComponent.vue'
// import ViewComponent from '../components/admin/MaintenanceManagement/ViewComponent.vue'
import CreateCourseComponent from '../components/admin/Course/CreateCourseComponent.vue'
import IndexCourseComponent from '../components/admin/Course/IndexCourseComponent'
import ViewCourseComponent from '../components/admin/Course/ViewCourseComponent.vue'
import ViewChapterComponent from '../components/admin/Chapters/ViewChapterComponent.vue'
import CreateChapterComponent from '../components/admin/Chapters/CreateChapterComponent.vue'
import ViewLessonComponent from '../components/admin/Lessons/ViewLessonComponent.vue'
import CreateLessonComponent from '../components/admin/Lessons/CreateLessonComponent.vue'
import ViewQuestionComponent from '../components/admin/Quizzes/ViewQuestionComponent.vue'
import ViewQuizComponent from '../components/admin/Quizzes/ViewQuizComponent.vue'
import CreateQuizComponent from '../components/admin/Quizzes/CreateQuizComponent.vue'
import ViewSubscriptionComponent from '../components/admin/Subscription/ViewSubscriptionComponent.vue'
import ViewAuthorComponent from '../components/admin/Authors/ViewAuthorComponent.vue'
// import CreateComponent from '../components/admin/MaintenanceManagement/Form/CreateComponent.vue'
import UserComponent from '../components/admin/UserManagement/UserAccount/ViewComponent.vue'
import CreateUserComponent from '../components/admin/UserManagement/UserAccount/Form/CreateUserComponent.vue'
import UserGroupComponent from '../components/admin/UserManagement/UserGroup/ViewComponent.vue'
import CreateUserGroupComponent from '../components/admin/UserManagement/UserGroup/Form/CreateUserGroupComponent.vue'
import RolesAndPermissionComponent from '../components/admin/UserManagement/RolesAndPermissions/RolesAndPermissionComponent'
// import MarketingViewComponent from '../components/admin/Marketing/Template/MarketingViewComponent.vue'
// import MarketingJamComponent from '../components/admin/Marketing/MarketingJamComponent.vue'
// import EverwebinarIndexComponent from '../components/admin/Marketing/Everwebinar/EverwebinarIndexComponent.vue'
// import CheckoutIndexComponent from '../components/admin/Marketing/Checkout/CheckoutIndexComponent.vue'
// import DashboardComponent from '../components/admin/FrontEndPayments/DashboardComponent.vue'
// import PhoneSalesComponent from '../components/admin/FrontEndPayments/PhoneSalesComponent.vue'
// import PaymentScheduleComponent from '../components/admin/FrontEndPayments/PaymentScheduleComponent.vue'
import Login from '../components/layout/Login.vue'
// import CustomerServiceIndexComponent from '../components/admin/CustomerService/CustomerServiceIndexComponent'
import UnauthorizedComponent from '../components/errors/403.vue'
import NotFoundComponent from '../components/errors/404.vue'


export const routes = [
    {
        path:'/logins',
        component:Login,
        name: 'Login',
        group: 'default',
        icon: '',
        type: '',
        key: ''
    }, 
     /**
      * Error Pages
      */
    {path: '*', component: NotFoundComponent, 'name': 'error.404',},
    {path: '/unauthorized', component: UnauthorizedComponent, 'name': 'error.403',},
    {
        path:'/',
        component:Dashboard,
        name: 'Dashboard',
        group: 'default',
        icon: '',
        type: '',
        key: ''
    },
    {
        path:'/course-management/all-courses',
        component: IndexCourseComponent,
        name: 'Courses',
        group: 'course-managemnent',
        icon: '<i class="fas fa-book parent-nav-icon"></i>',
        type: 'child',
        key: 'maintenance_schedule_view',
        meta: {
            permission: 'maintenance_schedule.view'
        }
    },
    {
        path:'/chapter-management/all-chapters',
        component:ViewChapterComponent,
        name: 'Chapters',
        group: 'chapter-management',
        icon: '<i class="fas fa-layer-group"></i>',
        type: 'child',
        key: 'maintenance_schedule_view',
        meta: {
            permission: 'maintenance_schedule.view'
        }
    },
    {
        path:'/lesson-management/all-lessons',
        component:ViewLessonComponent,
        name: 'Lessons',
        group: 'lesson-management',
        icon: '<i class="fas fa-hand-holding-usd"></i>',
        type: 'child',
        key: 'fe_phone_sales',
        meta: {
            permission: 'fe_phone_sales'
        }
    },
    {
        path:'/quiz-management/all-quizzes',
        component:ViewQuizComponent,
        name: 'Quizzes',
        group: 'quizzes',
        icon: '<i class="fas fa-project-diagram"></i>',
        type: 'child',
        key: 'fe_phone_sales',
        meta: {
            permission: 'fe_phone_sales'
        }
    },

    {
        path:'/quiz-management/all-questions',
        component:ViewQuestionComponent,
        name: 'All Questions',
        is_title: true,
        group: 'quizzes',
        icon: '<i class="fas fa-podcast"></i>',
        type: 'child',
        key: 'everwebinar_page_view',
        meta: {
            permission: 'everwebinar_page.view'
        }
    },
    {
        path:'/subscription-products/all-products',
        component:ViewSubscriptionComponent,
        name: 'Subscriptions',
        is_title: true,
        group: 'subscription-products',
        icon: '<i class="far fa-address-card"></i>',
        type: 'child',
        key: 'customer_lookup_view',
        meta: {
            permission: 'customer_lookup.view'
        }
    },

    {
        path:'/authors/all-authors',
        component:ViewAuthorComponent,
        name: 'All Authors',
        is_title: true,
        group: 'authors',
        icon: '<i class="far fa-address-card"></i>',
        type: 'child',
        key: 'customer_lookup_view',
        meta: {
            permission: 'customer_lookup.view'
        }
    },
    {
        path:'/user-management/user-list',
        component:UserComponent,
        name: 'User Accounts',
        is_title: true,
        group: 'user-management',
        icon: '<i class="fas fa-user"></i>',
        type: 'child',
        key: 'user_account_view',
        meta: {
            permission: 'user_account.view'
        }
    },
    // {
    //     path:'/course-management/all-courses',
    //     component: IndexCourseComponent,
    //     name: 'Courses',
    //     group: 'course-managemnent',
    //     icon: '<i class="fas fa-book parent-nav-icon"></i>',
    //     type: 'parent',
    //     key: ''
    // },
    //     {
    //         path:'/course-management/all-courses',
    //         component: IndexCourseComponent,
    //         name: 'All Courses',
    //         is_title: true,
    //         group: 'course-managemnent',
    //         icon: '<i class="fas fa-book"></i>',
    //         type: 'child',
    //         key: 'maintenance_schedule_view',
    //         meta: {
    //             permission: 'maintenance_schedule.view'
    //         }
    //     },
    //     {
    //         path:'/course-management/create-new-course',
    //         component:CreateCourseComponent,
    //         name: 'Create New Course',
    //         is_title: true,
    //         group: 'course-managemnent',
    //         icon: '<i class="fas fa-book-medical"></i>',
    //         type: 'child',
    //         key: 'maintenance_schedule_view',
    //         meta: {
    //             permission: 'maintenance_schedule.view'
    //         }
    //     },

    // {
    //     path:'/chapter-management/all-chapters',
    //     component:ViewChapterComponent,
    //     name: 'Chapters',
    //     group: 'chapter-management',
    //     icon: '<i class="fas fa-layer-group"></i>',
    //     type: 'parent',
    //     key: ''
    // },
    //     {
    //         path:'/chapter-management/all-chapters',
    //         component:ViewChapterComponent,
    //         name: 'All Chapters',
    //         is_title: true,
    //         group: 'chapter-management',
    //         icon: '<i class="fas fa-layer-group"></i>',
    //         type: 'child',
    //         key: 'user_account_view',
    //         meta: {
    //             permission: 'user_account.view'
    //         }
    //     },
    //     {
    //         path:'/chapter-management/create-chapter',
    //         component:CreateChapterComponent,
    //         name: 'Create New Chapter',
    //         is_title: true,
    //         group: 'chapter-management',
    //         icon: '<i class="fas fa-plus"></i>',
    //         type: 'child',
    //         key: 'role_and_permission_view',
    //         meta: {
    //             permission: 'role_and_permission.view'
    //         }
    //     },
    // {
    //     path:'/lesson-management/all-lessons',
    //     component:ViewLessonComponent,
    //     name: 'Lessons',
    //     group: 'lesson-management',
    //     icon: '<i class="fas fa-hand-holding-usd"></i>',
    //     type: 'parent',
    //     key: 'fe_phone_sales',
    //     meta: {
    //         permission: 'fe_phone_sales'
    //     }
    // },
    //     {
    //         path:'/lesson-management/all-lessons',
    //         component:ViewLessonComponent,
    //         name: 'All Lessons',
    //         is_title: true,
    //         group: 'lesson-management',
    //         icon: '<i class="fas fa-chalkboard-teacher"></i>',
    //         type: 'child',
    //         key: 'fe_dashboard',
    //         meta: {
    //             permission: 'fe_dashboard'
    //         }
    //     },
    //     {
    //         path:'/lesson-management/create-lesson',
    //         component:CreateLessonComponent,
    //         name: 'Create New Lesson',
    //         is_title: true,
    //         group: 'lesson-management',
    //         icon: '<i class="fas fa-chalkboard-teacher"></i>',
    //         type: 'child',
    //         key: 'fe_phone_sales',
    //         meta: {
    //             permission: 'fe_phone_sales'
    //         }
    //     },
    // {
    //     path:'/quiz-management/all-quizzes',
    //     component:ViewQuizComponent,
    //     name: 'Quizzes',
    //     group: 'quizzes',
    //     icon: '<i class="fas fa-project-diagram"></i>',
    //     type: 'parent',
    //     key: ''
    // },
    //     {
    //         path:'/quiz-management/all-quizzes',
    //         component:ViewQuizComponent,
    //         name: 'All Quizzes',
    //         is_title: true,
    //         group: 'quizzes',
    //         icon: '<i class="fas fa-poll"></i>',
    //         type: 'child',
    //         key: 'marketing_template_view',
    //         meta: {
    //             permission: 'marketing_template.view'
    //         }
    //     },
    //     {
    //         path:'/quiz-management/all-questions',
    //         component:ViewQuestionComponent,
    //         name: 'All Questions',
    //         is_title: true,
    //         group: 'quizzes',
    //         icon: '<i class="fas fa-podcast"></i>',
    //         type: 'child',
    //         key: 'everwebinar_page_view',
    //         meta: {
    //             permission: 'everwebinar_page.view'
    //         }
    //     },
    //     // {
    //     //     path: '/marketing/checkout',
    //     //     component: CheckoutIndexComponent,
    //     //     name: 'Checkout Pages',
    //     //     is_title: true,
    //     //     group: 'marketing',
    //     //     icon: '<i class="fas fa-shopping-cart"></i>',
    //     //     type: 'child',
    //     //     key: 'checkout_page_view',
    //     //     meta: {
    //     //         permission: 'checkout_page.view'
    //     //     }
    //     // },
    // {
    //     path:'/subscription-products/all-products',
    //     component:ViewSubscriptionComponent,
    //     name: 'Subscription Products',
    //     group: 'subscription-products',
    //     icon: '<i class="fas fa-headset"></i>',
    //     type: 'parent',
    //     key: '',
    //     meta: {
    //         permission: 'customer_lookup.view'
    //     }
    // },
    //     {
    //         path:'/subscription-products/all-products',
    //         component:ViewSubscriptionComponent,
    //         name: 'Subscriptions',
    //         is_title: true,
    //         group: 'subscription-products',
    //         icon: '<i class="far fa-address-card"></i>',
    //         type: 'child',
    //         key: 'customer_lookup_view',
    //         meta: {
    //             permission: 'customer_lookup.view'
    //         }
    //     },
    // {
    //     path:'/authors/all-authors',
    //     component:ViewAuthorComponent,
    //     name: 'Authors',
    //     group: 'authors',
    //     icon: '<i class="fas fa-headset"></i>',
    //     type: 'parent',
    //     key: '',
    //     meta: {
    //         permission: 'customer_lookup.view'
    //     }
    // },
    //     {
    //         path:'/authors/all-authors',
    //         component:ViewAuthorComponent,
    //         name: 'All Authors',
    //         is_title: true,
    //         group: 'authors',
    //         icon: '<i class="far fa-address-card"></i>',
    //         type: 'child',
    //         key: 'customer_lookup_view',
    //         meta: {
    //             permission: 'customer_lookup.view'
    //         }
    //     },
    // {
    //     path:'/user-management/user-list',
    //     component:UserComponent,
    //     name: 'User Management',
    //     group: 'user-management',
    //     icon: '<i class="fas fa-users-cog"></i>',
    //     type: 'parent',
    //     key: ''
    // },
    //     {
    //         path:'/user-management/user-list',
    //         component:UserComponent,
    //         name: 'User Accounts',
    //         is_title: true,
    //         group: 'user-management',
    //         icon: '<i class="fas fa-user"></i>',
    //         type: 'child',
    //         key: 'user_account_view',
    //         meta: {
    //             permission: 'user_account.view'
    //         }
    //     },
    //     {
    //         path:'/user-management/create-user',
    //         component:CreateUserComponent,
    //         name: 'Create New User',
    //         is_title: false,
    //         group: 'user-management',
    //         icon: '<i class="fas fa-user-plus"></i>',
    //         type: 'child',
    //         key: 'user_account_create',
    //         meta: {
    //             permission: 'user_account.create'
    //         }
    //     },
    //     {
    //         path:'/user-management/roles-and-permissions',
    //         component:RolesAndPermissionComponent,
    //         name: 'Roles and Permissions',
    //         is_title: true,
    //         group: 'user-management',
    //         icon: '<i class="fas fa-user-lock"></i>',
    //         type: 'child',
    //         key: 'role_and_permission_view',
    //         meta: {
    //             permission: 'role_and_permission.view'
    //         }
    //     },
    //     {
    //         path:'/user-management/user-group-list',
    //         component:UserGroupComponent,
    //         name: 'User Groups',
    //         is_title: true,
    //         group: 'user-management',
    //         icon: '<i class="fas fa-users"></i>',
    //         type: 'child',
    //         key: 'user_group_view',
    //         meta: {
    //             permission: 'user_group.view'
    //         }
    //     },
    //     {
    //         path:'/user-management/create-user-group',
    //         component:CreateUserGroupComponent,
    //         name: 'Create New User Group',
    //         is_title: false,
    //         group: 'user-management',
    //         icon: '<i class="fas fa-user-plus"></i>',
    //         type: 'child',
    //         key: 'user_group_create',
    //         meta: {
    //             permission: 'user_group.create'
    //         }
    //     }
];
