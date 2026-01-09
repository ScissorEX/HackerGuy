import { createRouter, createWebHistory } from "vue-router";
import Welcome from "../resources/views/Welcome.vue";
import Home from "../resources/views/Home.vue";
import { useAuthStore } from "../resources/js/Stores/AuthHandling";

const routes = [
    {
        path: "/",
        components: { default: Welcome },
        children: [
            { path: "/", name: "home", component: Home },
            {
                path: "products",
                name: "products",
                component: () => import("../resources/views/Products.vue"),
            },
            {
                path: "solutions",
                name: "solutions",
                component: () => import("../resources/views/Solutions.vue"),
            },
            {
                path: "resources",
                name: "resources",
                component: () => import("../resources/views/Resources.vue"),
            },
            {
                path: "pricing",
                name: "pricing",
                component: () => import("../resources/views/Pricing.vue"),
            },
            {
                path: "requestdemo",
                name: "requestdemo",
                component: () => import("../resources/views/RequestDemo.vue"),
            },
        ],
    },
    {
        path: "/signup",
        name: "signup",
        component: () => import("../resources/views/Signup.vue"),
        meta: { guest: true }
    },
    {
        path: "/community",
        name: "community",
        component: () => import("../resources/views/Community.vue"),
        children: [
            {
                path: "",
                name: "allposts",
                component: () =>
                    import("../resources/components/communitypostcard.vue"),
            },
            {
                path: "postsearch",
                name: "postsearch",
                component: () =>
                    import("../resources/views/communitypostsearch.vue"),
            },
            {
                path: ":id/:slug",
                name: "viewpost",
                component: () =>
                    import("../resources/views/Communityviewpost.vue"),
            },
        ],
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "link-active-chimp",
});

router.beforeEach(async (to, from) => {
    const authStore = useAuthStore();
    await authStore.getUser();

    if (authStore.user && to.meta.guest) {
        return { name: "home" };
    }

    if (!authStore.user && to.meta.auth) {
        return { name: "signup" };
    }
});

export default router;
