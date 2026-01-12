<template>
    <div>
        <div id="loading" v-if="loading">
            <p>Loading</p>
        </div>
        <div v-if="error" class="error">{{ error }}</div>
        <div v-if="userdata">
            <div id="namediv">
                <p id="handle">@{{ userdata.handle }}</p>
                <p id="username">{{ userdata.name }}</p>
            </div>
            <div id="usercreations">
                <div id="deck" v-for="post in userdata.posts" :key="post.id">
                    <a @click="showpost(post)" id="thecard">
                        <h3>{{ post.title }}</h3>
                        <p>{{ post.content }}</p>
                        <span>By {{ userdata.name }}</span>
                    </a>
                </div>
                <div id="deck" v-for="comment in userdata.comments" :key="comment.id">
                    <a @click="showpost(post)" id="thecard">
                        <p>{{ comment.content }}</p>
                        <span>By {{ userdata.name }}</span>
                    </a>
                </div>
            </div>
            what up {{ userdata }}
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from "../js/Stores/AuthHandling";
import { useUserStore } from "../js/Stores/UserHandling";
import { useRoute, useRouter } from "vue-router";
import { ref, onMounted } from "vue";
const authStore = useAuthStore();
const userStore = useUserStore();
const loading = ref(false);
const userdata = ref(null);
const error = ref(null);

const route = useRoute();
const router = useRouter();
const handle = route.params.handle;

async function getuser() {
    error.value = null;
    loading.value = true;
    try {
        const data = await userStore.getuserdata(handle);
        userdata.value = data;
    } catch (err) {
        error.value = err.toString();
    } finally {
        loading.value = false;
    }
}

function showpost(post) {
    router.push({ name: "viewpost", params: { id: post.id, slug: post.slug } });
}
onMounted(getuser);
</script>

<style scoped>
#namediv {
    background-color: rgb(180, 180, 180);
    display: flex;
    padding: 40px 20px 10px 20px;
    flex-direction: column;
}
#handle {
    margin: 0;
    font-size: 15px;
}
#username {
    margin: 0;
    font-size: 30px;
}
#thecard{
    width: 300px;
    display: flex;
    flex-direction: column;
    margin: auto;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
#usercreations{
    display: flex;
    justify-content: space-around;
}
</style>
