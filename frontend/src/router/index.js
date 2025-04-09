

import { createRouter, createWebHistory } from 'vue-router'
import Login from '../pages/Login.vue'
import Translations from '../pages/TranslationManager.vue'

const routes = [
    {
        path: '/',
        redirect: () => {
            const token = localStorage.getItem('token')
            return token ? '/translations' : '/login'
        }
    },
    {
        path: '/login',
        component: Login,
    },
    {
        path: '/translations',
        component: Translations,
        meta: { requiresAuth: true }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token')

    if (to.meta.requiresAuth && !token) {
        next('/login')
    } else if (to.path === '/login' && token) {
        next('/translations')
    } else {
        next()
    }
})

export default router;
