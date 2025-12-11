<template>
    
        <div v-if="loading">Loading</div>

        <div v-if="error" class="error">{{ error }}</div>

        <div id="body" v-if="post">
            <h2>{{ post.title }}</h2>
            <p>{{ post.content }}</p>
            <p>{{ post.comments.length }} comments</p>

            <h3>by {{ post.author.name }}</h3>
            <h4>upvotes {{ upvote }} | {{ downvote }} downvotes</h4>
            <button @click="votesubmit(1,type,post.id)"> upvote</button>
             <button @click="votesubmit(-1,type,post.id)"> downvote</button>
            <!-- <comment v-for="comment in post.comments" :key="comment.id" :comment="comment"></comment> -->
        </div>
</template>

<script setup>
import { useVoteStore } from '../js/Stores/VoteHandling.js';
import { storeToRefs } from 'pinia';


//votesubmit(vote,type,route)

import { ref, watch,reactive, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { usePostStore } from '../js/Stores/PostHandling.js'
import comment from '../components/communitycomment.vue';

const { getPost } = usePostStore();

const route = useRoute()

const loading = ref(false)
const post = ref(null)
const error = ref(null)
const type = "posts"
const upvote = post.downvotecount
const downvote = ref(post.downvotecount)

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

const { errors } = storeToRefs(useVoteStore());
const { votesubmit } = useVoteStore();

onMounted(() => (errors.value = {}));
</script>

<style scoped></style>