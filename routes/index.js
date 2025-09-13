import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    { path: '/',  component: () => import('../resources/views/Home.vue') },
    { path: '/products', component: () => import('../resources/views/Products.vue') },
    { path: '/solutions', component: () => import('../resources/views/Solutions.vue') },
    { path: '/resources', component: () => import('../resources/views/Resources.vue') },
    { path: '/pricing', component: () => import('../resources/views/Pricing.vue') },
    { path: '/signup', component: () => import('../resources/views/Signup.vue') },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass : 'link-active-chimp'
});

export default router;
