<template>
    <div style="height: 100dvh; display: flex; flex-direction: column;">
        <communityhead></communityhead>
        <div id="body">
            <aside id="aside">
                <div>
                    <router-link to="/community" class="button">
                        <img alt="house" src="../components/images/icons/home.svg"/>
                        Home</router-link
                    >
                </div>
                <div></div>
            </aside>
            <div id="content" > <postcard v-for="post in posts" :key="post.id" :post="post" ></postcard></div>
        </div>
    </div>
</template>

<script setup>
import communityhead from '../components/communityhead.vue';
import postcard from '../components/communitypostcard.vue';
import { usePostStore } from '../js/Stores/PostHandling';
import { onMounted, ref } from 'vue';

const { getListPosts } = usePostStore();
const posts = ref([]);
onMounted(async()=>{posts.value = await getListPosts()});
</script>

<style scoped>
#body {
    background-color: blue;
    max-width: 1200px;
    width: 100%;
    background: none;
    display: flex;
    justify-content: space-between;
    margin: 0 auto;
    height: 100%;
}
#content {
    background-color: chartreuse;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(5, 1fr);
    gap: 8px;
}
#aside {
    background-color: aqua;
    width: 25%;
}
</style>
