import welcomepage from '../resources/vue/welcomepage.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [

        {path: '/', name: 'Home', component: welcomepage}
    
    ]



const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;