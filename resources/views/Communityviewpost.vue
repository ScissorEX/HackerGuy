<template>
    
        <div v-if="loading">Loading</div>

        <div v-if="error" class="error">{{ error }}</div>

        <div id="body" v-if="post">
            <h2>{{ post.title }}</h2>
            <p>{{ post.content }}</p>
            <p>{{ post.comments.length }} comments</p>
            <h3>by {{ post.author.name }}</h3>
            <comment v-for="comment in post.comments" :key="comment.id" :comment="comment"></comment>
        </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { usePostStore } from '../js/Stores/PostHandling.js'
import comment from '../components/communitycomment.vue';

const { getPost } = usePostStore();

const route = useRoute()

const loading = ref(false)
const post = ref(null)
const error = ref(null)

watch(() => route.params.id, fetchdata, { immediate: true })


async function fetchdata(id) {
    error.value = post.value = null
    loading.value = true

    try {
        getPost(id)
        post.value = await getPost(id)  
    } catch (err) {
    error.value = err.toString()
  } finally {
    loading.value = false
  }
}
</script>

<style scoped></style>