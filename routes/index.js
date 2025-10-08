import { createRouter, createWebHistory } from 'vue-router';
import Welcome from '../resources/views/Welcome.vue';
import Home from '../resources/views/Home.vue';

const routes = [
    {
        path: '/',
        components: { default: Welcome },
        children: [
            { path: '/', component: Home },
            { path: '/products', component: () => import('../resources/views/Products.vue') },
            { path: '/solutions', component: () => import('../resources/views/Solutions.vue') },
            { path: '/resources', component: () => import('../resources/views/Resources.vue') },
            { path: '/pricing', component: () => import('../resources/views/Pricing.vue') },
            { path: '/requestdemo', component: () => import('../resources/views/RequestDemo.vue') },
        ],
    },
    { path: '/signup', component: () => import('../resources/views/Signup.vue') },
    { path: '/community', component: () => import('../resources/views/Community.vue') },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'link-active-chimp',
});
export default router;