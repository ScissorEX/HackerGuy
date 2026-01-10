<template>
    <div id="content">
        <div v-for="post in searchStore.searchres" :key="post.id">
            <div id="separator"></div>
            <a @click="showpost(post)" id="thecard">
                <h3>{{ post.title }}</h3>
                <p>{{ post.content }}</p>
                <span>By {{ post.author.name }}</span>
            </a>
        </div>
        <div v-if="searchStore.searchres.length == 0">no posts</div>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { useSearchStore } from "../js/Stores/SearchHandling";

const searchStore = useSearchStore();
const router = useRouter();

function showpost(post) {
    router.push({ name: "viewpost", params: { id: post.id, slug: post.slug } });
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
    height: 70px;
    align-content: center;
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
#createpostcontainer {
    width: 300px;
    height: 300px;
    position: absolute;
    background-color: aquamarine;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 11;
}
</style>
