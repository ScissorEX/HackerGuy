<template>
    <div id="content">
        <div id="postsfilterandthelikes">
            <router-link to="/community/createpost" id="createbutton" class="button">create post
                +</router-link>
                <div>
                    
                </div>
        </div>
        <div v-for="post in posts" :key="post.id">
            <div id="separator"></div>
            <a @click="showpost(post)" id="thecard">
                <h3>{{ post.title }}</h3>
                <p>{{ post.content }}</p>
                <span>By {{ post.author.name }}</span>
            </a>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { usePostStore } from '../js/Stores/PostHandling';
import { onMounted, ref } from 'vue';

const { getListPosts } = usePostStore();
const posts = ref([]);

onMounted(async () => { posts.value = await getListPosts() });

const router = useRouter();
function showpost(post) {
    router.push({ name: "viewpost", params: { id: post.id, slug: post.slug } })
}
</script>

<style scoped>
#content {
    width: 95%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    justify-self: center;
    align-items: center;
    gap: 8px;
    overflow: visible;
}

#thecard {
    background-color: #fff;
}

#separator {
    background-color: #d8d8d8;
    height: 2px;
    margin: 5px 0;
    width: 80%;
    justify-self: center;
}

#postsfilterandthelikes {
    height: 20px;
}

#createbutton {
    padding: 7px 15px;
    border-radius: 7px;
    margin: 2px;
    border: none;
    font-weight: 400;
    font-size: 16px;
    cursor: pointer;
    background-color: #00e199;
    color: #072c09;
}
</style>