import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import { useUserStore } from '../store/user';

const routes: Array<RouteRecordRaw> = [
    {
        path: '/auth',
        component: () => import('../pages/auth/AuthPage.vue'),
        meta: { requireGuest: true },
        children: [
            {
                path: '/registro',
                name: 'auth.register',
                component: () => import('../pages/auth/RegisterPage.vue')
            },
            {
                path: '/login',
                name: 'auth.login',
                component: () => import('../pages/auth/LoginPage.vue')
            }
        ]
    },
    {
        path: '/admin',
        component: () => import('../pages/admin/AdminPage.vue'),
        meta: { requireAuth: true },
        children: [
            {
                path: '/admin',
                name: 'admin',
                component: () => import('../pages/admin/dashboard/DashboardPage.vue')
            },
            {
                path: '/miembros',
                name: 'members',
                component: () => import('../pages/admin/member/MemberPage.vue'),
            },
            {
                path: '/crear-miembro',
                name: 'create.member',
                component: () => import('../pages/admin/member/MemberForm.vue'),
            },
            {
                path: '/editar-miembro/:id',
                name: 'edit.member',
                component: () => import('../pages/admin/member/MemberForm.vue'),
            },
            {
                path: '/projectos',
                name: 'projects',
                component: () => import('../pages/admin/project/ProjectPage.vue'),
            },
            {
                path: '/crear-proyecto',
                name: 'create.project',
                component: () => import('../pages/admin/project/ProjectForm.vue'),
            },
            {
                path: '/projecto/editar/:id',
                name: 'edit.project',
                component: () => import('../pages/admin/project/ProjectForm.vue'),
            },
            {
                path: '/kaban',
                name: 'kaban',
                component: () => import('../pages/admin/kabanboard/KabanBoard.vue'),
            },
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        component: () => import('../pages/NotFound.vue'),
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const { token } = useUserStore();

    if (to.meta.requireAuth && !token) {
        next({ name: 'auth.login' });
    } else if (to.meta.requireGuest && token) {
        next({ name: 'admin' });
    } else {
        next();
    }
});

export default router;