<template>
    <div id="content">
    <a v-for="post in posts" :key="post.id" @click="showpost(post)" id="thecard">
        <h3>{{ post.title }}</h3>
        <p>{{ post.content }}</p>
        <span>By {{ post.author.name }}</span>
    </a>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { usePostStore } from '../js/Stores/PostHandling';
import { onMounted, ref } from 'vue';

const { getListPosts } = usePostStore();
const posts = ref([]);

onMounted(async()=>{posts.value = await getListPosts()});

const router = useRouter();
function showpost(post) {
    router.push({ name: "viewpost", params: { id: post.id, slug: post.slug }})
}
</script>

<style scoped>
    #content {
    background-color: rgb(158, 158, 158);
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}
#thecard {
    background-color: #fff;
    border-radius: 10px;
    width: 400px;
}
</style>