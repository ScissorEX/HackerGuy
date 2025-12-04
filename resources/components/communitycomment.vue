<template>
    <p>{{ comment.title }}</p>
    <p>{{ comment.content }}</p>
    <p>{{ comment.author.name}}</p>
</template>

<script setup>
defineProps({
    comment: {
        type: Object,
        required: true
    }
});
</script>

<style scoped>

</style>