

import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Home.vue'
import Login from '../components/Login.vue'
import Translations from '../components/TranslationList.vue'
import Add from '../components/AddTranslation.vue'
import Export from '../components/ExportTranslation.vue'
import api from '../api.js'

const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login },
    {
        path: '/translations',
        component: Translations,
        meta: { requiresAuth: true }
    },
    {
        path: '/add',
        component: Add,
        meta: { requiresAuth: true }
    },
    {
        path: '/export',
        component: Export,
        meta: { requiresAuth: true }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// router.beforeEach(async (to, from, next) => {
//     if (!to.meta.requiresAuth) return next()

//     try {
//         await api.get('/api/user')
//         next()
//     } catch {
//         next('/login')
//     }
// })

export default router;
