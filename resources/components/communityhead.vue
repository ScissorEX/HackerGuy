<template>
    <div id="biggestheader">
        <div id="headernavmain">
            <router-link to="/" id="chimprankrouter" class="button">
                <p id="chimprank">ChimpRank</p>
                <img
                    src="../components/images/icons/monkey.svg"
                    alt="icon"
                    id="chimpranklogo"
                />
            </router-link>

            <form id="headnavlink" @submit.prevent="searching(search)">
                <button id="searchbutton">
                    <img
                        src="../components/images/icons/search.svg"
                        id="searchicon"
                    />
                </button>
                <input id="searchbar" v-model="search" />
            </form>

            <userprofileicon v-if="authStore.user"></userprofileicon>

            <div v-else>
                <router-link to="/signup" id="signupbutton" class="button"
                    >Sign Up</router-link
                >
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useSearchStore } from "../js/Stores/SearchHandling";
import { useAuthStore } from "../js/Stores/AuthHandling.js";
import { useRouter } from "vue-router";
import Userprofileicon from "./userprofileicon.vue";

const searchStore = useSearchStore();
const authStore = useAuthStore();
const router = useRouter();
const search = ref();

async function searching(a) {
    try {
        await searchStore.searchpost(a);
        router.push({ name: "postsearch" });
    } catch {
        return console.log("error");
    }
}
</script>

<style scoped>
#biggestheader {
    width: 100%;
    background-color: oklch(0.3 0.05 250);
    justify-items: center;
    box-shadow: 0 1px 2px 0 hsla(0, 0%, 100%, 0.1);
}

#headernavmain {
    padding: 0px 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    width: 50%;
}

#headnavlink {
    margin: 0 30px;
    padding: 1px 3px;
    border-radius: 15px;
    background-color: oklch(0.5 0.05 250);
    display: flex;
    justify-content: space-between;
    width: 600px;
    border: solid 2px #192939;
}

#searchbar {
    padding: 1px 15px;
    margin: 0;
    width: 100%;
    border: none;
    color: white;
    outline: none;
    font-size: 1.3rem;
    line-height: 2rem;
    background: transparent;
}
#searchbar:focus {
    background-color: #00e199;
}

#signupbutton {
    padding: 7px 15px;
    border-radius: 7px;
    margin: 2px;
    border: none;
    font-weight: 400;
    font-size: 16px;
    cursor: pointer;
}

#signupbutton {
    background-color: #00e199;
    color: #072c09;
}
#chimprankrouter {
    width: 120px;
    height: 50px;
    display: flex;
}

#chimprank {
    font-size: 15px;
    font-weight: 600;
    margin-top: 22px;
}

#chimpranklogo {
    position: relative;
    right: 7px;
    height: 30px;
    margin-top: 7px;
}

#searchbutton {
    border-radius: 12px;
    background-color: oklch(0.7 0.05 250);
    border: none;
    margin: 1px;
    width: 60px;
}
</style>
