<template>
    <a @click="showpost(post)" id="thecard">
        <h3>{{ post.title }}</h3>
        <p>{{ post.content }}</p>
        <span>By {{ post.author.name }}</span>
    </a>
</template>

<script setup>
defineProps({
    post: {
        type: Object,
        required: true
    }
});
import { useRouter } from 'vue-router';

const router = useRouter();
function showpost(post) {
    router.push({ name: "viewpost", params: { id: post.id, slug: post.slug }, props: true })
}
</script>

<style scoped>
#thecard {
    background-color: #fff;
    border-radius: 10px;
    width: 400px;
}
</style>