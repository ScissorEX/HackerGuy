<template>
    <div id="headernavmain">
        <div id="headleftside">
            <router-link to="/" id="chimprankrouter" class="button">
                <p id="chimprank">ChimpRank</p>
                <img
                    v-show="show"
                    src="./images/icons/monkey.svg"
                    alt="icon"
                    id="chimpranklogo"
                />
            </router-link>

            <div id="headnavlink">
                <router-link
                    to="/products"
                    id="headlink"
                    class="button"
                    @mouseenter="preloadproducts"
                    >Products</router-link
                >

                <router-link
                    to="/solutions"
                    id="headlink"
                    class="button"
                    @mouseenter="preloadsolutions"
                    >Solutions</router-link
                >

                <router-link
                    to="/resources"
                    id="headlink"
                    class="button"
                    @mouseenter="preloadresources"
                    >Resources</router-link
                >

                <router-link
                    to="/community"
                    id="headlink"
                    class="button"
                    >Community
                    <img
                        src="../components/images/icons/out.svg"
                        style="width: 20px; transform: rotate(90deg)"
                /></router-link>
            </div>
        </div>
        <div>
            for dev=>
            <router-link to="/requestdemo" id="demobutton" class="button"
                >Request Demo</router-link
            >
            <userprofileicon v-if="authStore.user"></userprofileicon>
            <router-link
                to="/signup"
                id="signupbutton"
                class="button"
                v-else="authStore.user"
                >Sign Up</router-link
            >
        </div>
    </div>
    <div id="cookiemonster" class="blackbgc" v-if="!cookiedecision">
        accept the cookie
        <div style="display: flex">
            <div>
                <button
                    id="nocookie"
                    class="button"
                    @click="cookiedecision = true"
                >
                    Decline
                </button>
                <input
                    type="button"
                    value="Accept"
                    id="acceptcookie"
                    class="button"
                    @click="cookie()"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from "../js/Stores/AuthHandling";
import { onMounted, ref } from "vue";
import Userprofileicon from "./userprofileicon.vue";
const preloadproducts = () => {
    import("../views/Products.vue");
};
const preloadsolutions = () => {
    import("../views/Solutions.vue");
};
const preloadresources = () => {
    import("../views/Resources.vue");
};

const authStore = useAuthStore();
let show = ref(true);
const cookiedecision = ref();

onMounted(
    () =>
        (cookiedecision.value = document.cookie.match("random number")
            ? true
            : false),
);

function cookie() {
    document.cookie =
        "random number" + "=" + Math.floor(Math.random() * 100) + ";";
    cookiedecision.value = true;
}
</script>

<style scoped>
#headernavmain {
    padding: 0px 30px;
    color: white;
    display: flex;
    align-items: center;
    box-shadow: 0 1px 2px 0 hsla(0, 0%, 100%, 0.1);
    z-index: 2;
}

#headleftside {
    display: flex;
    align-items: center;
    flex: 2;
}

#headnavlink {
    margin-left: 100px;
}

#headleftside .link-active-chimp {
    color: rgb(218, 218, 218);
}

#headlink {
    padding: 20px;
    color: #969696;
}

#signupbutton,
#demobutton,
#acceptcookie,
#nocookie {
    padding: 7px 15px;
    border-radius: 7px;
    margin: 2px;
    border: none;
    font-weight: 400;
    font-size: 16px;
    cursor: pointer;
}

#signupbutton,
#acceptcookie {
    background-color: #00e199;
    color: #072c09;
}

#demobutton,
#nocookie {
    background-color: #1f1f1f;
    color: #d8d8d8;
}

#acceptcookie,
#nocookie {
    padding: 10px 15px;
}

#chimprankrouter {
    width: 200px;
    height: 100px;
    display: flex;
}

#chimprank {
    font-size: 30px;
    font-weight: 600;
    margin-top: 40px;
}

#chimpranklogo {
    position: relative;
    right: 7px;
    height: 50px;
    margin-top: 20px;
}

#cookiemonster {
    position: fixed;
    background-color: #161616;
    bottom: 150px;
    width: min(50dvw, 1000px);
    justify-self: center;
    border-radius: 15px;
    padding: 20px;
    height: 80px;
    display: flex;
}
</style>
