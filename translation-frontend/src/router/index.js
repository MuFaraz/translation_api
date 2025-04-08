import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import TranslationList from '../components/TranslationList.vue';
import AddTranslation from '../components/AddTranslation.vue';
import ExportTranslation from '../components/ExportTranslation.vue';

const routes = [
    { path: '/', name: 'Home', component: Home },
    { path: '/translations', name: 'List', component: TranslationList },
    { path: '/add', name: 'Add', component: AddTranslation },
    { path: '/export', name: 'Export', component: ExportTranslation },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
