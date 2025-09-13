import Home from '../resources/views/Home.vue';
import Products from '../resources/views/Products.vue';
import Solutions from '../resources/views/Solutions.vue';
import Resources from '../resources/views/Resources.vue';
import Pricing from '../resources/views/Pricing.vue';
import Signup from '../resources/views/Signup.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    { path: '/', name: 'Home', component: Home },
    { path: '/products', name: 'Products', component: Products },
    { path: '/solutions', name: 'Solutions', component: Solutions },
    { path: '/resources', name: 'Resources', component: Resources },
    { path: '/pricing', name: 'Pricing', component: Pricing },
    { path: '/signup', name: 'Signup', component: Signup },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
