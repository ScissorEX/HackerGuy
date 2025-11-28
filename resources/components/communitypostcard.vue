<template>
    <div id="thecard">
        <h3>{{ post.title }}</h3>
        <p>{{ post.content }}</p>
        <span>By {{ post.author?.name }}</span>
    </div>
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
    
}
</style>