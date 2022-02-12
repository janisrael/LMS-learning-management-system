import Vue from 'vue'
import Router from 'vue-router'
import LoginComponent from '../components/Auth/LoginComponent'
import IndexCourseComponent from '../components/ContentPages/Course/IndexComponent'
import CreateCourseComponent from '../components/ContentPages/Course/CreateCourseComponent'

import IndexLessonComponent from '../components/ContentPages/Lesson/IndexLessonComponent'
// import ViewLessonComponent from '../components/ContentPages/Lesson/ViewLessonComponent'
import CreateLessonComponent from '../components/ContentPages/Lesson/CreateLessonComponent'

import IndexChapterComponent from '../components/ContentPages/Chapter/IndexChapterComponent'
import CreateChapterComponent from '../components/ContentPages/Chapter/CreateChapterComponent'

Vue.use(Router)
export const routes = [
    {
        path: '/login',
        component: LoginComponent,
        name: 'Login',
        group: 'default',
        icon: '',
        type: 'not-page',
        key: ''
    },
    /**
      * Error Pages
      */
    // {path: '*', component: NotFoundComponent, 'name': 'error.404',},
    // {path: '/unauthorized', component: UnauthorizedComponent, 'name': 'error.403',},
    // {
    //     path: '/',
    //     // component:Dashboard,
    //     name: 'Dashboard',
    //     group: 'default',
    //     icon: '',
    //     type: 'dashboard',
    //     key: ''
    // },
    {
        path: '/course-management/all-courses',
        component: IndexCourseComponent,
        name: 'Courses',
        group: 'course-managemnent',
        icon: '<i class="fas fa-book parent-nav-icon"></i>',
        type: 'page',
        key: 'maintenance_schedule_view',
        meta: {
            permission: 'maintenance_schedule.view'
        }
    },

    {
        path: '/course-management/create',
        component: CreateCourseComponent,
        name: 'New Course',
        group: 'course-managemnent',
        icon: '<i class="fas fa-book parent-nav-icon"></i>',
        type: 'create',
        key: 'maintenance_schedule_view',
        meta: {
            permission: 'maintenance_schedule.view'
        }
    },

    {
        path: '/course-management/edit-course',
        component: CreateCourseComponent,
        name: 'Edit Course',
        group: 'course-managemnent',
        icon: '<i class="fas fa-book parent-nav-icon"></i>',
        type: 'edit',
        key: 'maintenance_schedule_view',
        meta: {
            permission: 'maintenance_schedule.view'
        }
    },

    // chapter
    {
        path: '/chapter-management/all-chapters',
        component:IndexChapterComponent,
        name: 'Chapters',
        group: 'chapter-management',
        icon: '<i class="fas fa-layer-group"></i>',
        type: 'page',
        key: 'maintenance_schedule_view',
        meta: {
            permission: 'maintenance_schedule.view'
        }
    },
    {
        path: '/chapter-management/new-chapter',
        component:CreateChapterComponent,
        name: 'New Chapter',
        group: 'chapter-management',
        icon: '<i class="fas fa-layer-group"></i>',
        type: 'create',
        key: 'maintenance_schedule_view',
        meta: {
            permission: 'maintenance_schedule.view'
        }
    },
    {
        path: '/chapter-management/edit-chapter',
        component:CreateChapterComponent,
        name: 'Edit Chapter',
        group: 'chapter-management',
        icon: '<i class="fas fa-layer-group"></i>',
        type: 'edit',
        key: 'maintenance_schedule_view',
        meta: {
            permission: 'maintenance_schedule.view'
        }
    },

    // lesson
    {
        path: '/lesson-management/all-lessons',
        component:IndexLessonComponent,
        name: 'Lessons',
        group: 'lesson-management',
        icon: '<i class="fas fa-hand-holding-usd"></i>',
        type: 'page',
        key: 'fe_phone_sales',
        meta: {
            permission: 'fe_phone_sales'
        }
    },
    {
        path: '/lesson-management/new-lesson',
        component:CreateLessonComponent,
        name: 'New Lesson',
        group: 'lesson-management',
        icon: '<i class="fas fa-hand-holding-usd"></i>',
        type: 'create',
        key: 'fe_phone_sales',
        meta: {
            permission: 'fe_phone_sales'
        }
    },
    {
        path: '/lesson-management/edit-lesson',
        component:CreateLessonComponent,
        name: 'Edit Lesson',
        group: 'lesson-management',
        icon: '<i class="fas fa-hand-holding-usd"></i>',
        type: 'edit',
        key: 'fe_phone_sales',
        meta: {
            permission: 'fe_phone_sales'
        }
    },
    // quiz
    {
        path: '/quiz-management/all-quizzes',
        // component:ViewQuizComponent,
        name: 'Quizzes',
        group: 'quizzes',
        icon: '<i class="fas fa-project-diagram"></i>',
        type: 'page',
        key: 'fe_phone_sales',
        meta: {
            permission: 'fe_phone_sales'
        }
    },

    {
        path: '/quiz-management/all-questions',
        // component:ViewQuestionComponent,
        name: 'Questions',
        is_title: true,
        group: 'quizzes',
        icon: '<i class="fas fa-podcast"></i>',
        type: 'page',
        key: 'everwebinar_page_view',
        meta: {
            permission: 'everwebinar_page.view'
        }
    },
    {
        path: '/subscription-products/all-products',
        // component:ViewSubscriptionComponent,
        name: 'Subscriptions',
        is_title: true,
        group: 'subscription-products',
        icon: '<i class="far fa-address-card"></i>',
        type: 'page',
        key: 'customer_lookup_view',
        meta: {
            permission: 'customer_lookup.view'
        }
    },

    {
        path: '/authors/all-authors',
        // component:ViewAuthorComponent,
        name: 'Authors',
        is_title: true,
        group: 'authors',
        icon: '<i class="far fa-address-card"></i>',
        type: 'page',
        key: 'customer_lookup_view',
        meta: {
            permission: 'customer_lookup.view'
        }
    },
    {
        path: '/user-management/user-list',
        // component:UserComponent,
        name: 'User Accounts',
        is_title: true,
        group: 'user-management',
        icon: '<i class="fas fa-user"></i>',
        type: 'page',
        key: 'user_account_view',
        meta: {
            permission: 'user_account.view'
        }
    },
];