<template>
    <router-link to="/community" id="thecard">
        <h3>{{ post.title }}</h3>
        <p>{{ post.content }}</p>
        <span>By {{ post.author.name }}</span>
    </router-link>
</template>

<script setup>
    defineProps({
    post: {
        type: Object,
        required: true
    }
});
</script>

<style scoped>
#thecard{
    background-color: #fff;
    border-radius: 10px;
    width: 400px;
}
</style>