<template>
    <div id="headernavmain">
        <div id="headleftside">
            <router-link to="/" id="chimprankrouter">
                <p id="chimprank">ChimpRank</p>
                <img v-show="interval" src="./images/icons/monkey.svg" alt="icon" id="chimpranklogo">
            </router-link>

            <div id="headnavlink">
                <router-link to="/products" id="headlink" @mouseenter="preloadproducts">Products</router-link>

                <router-link to="/solutions" id="headlink" @mouseenter="preloadsolutions">Solutions</router-link>

                <router-link to="/resources" id="headlink" @mouseenter="preloadresources">Resources</router-link>

                <router-link to="/pricing" id="headlink" @mouseenter="preloadpricing">Pricing</router-link>
            </div>
            
        </div>
        <div>
            for dev=>
            <router-link to="/requestdemo" id="demobutton">Request Demo</router-link>
            <router-link to="/signup" id="signupbutton">Sign Up</router-link>
        </div>
    </div>
</template>

<script setup>
const preloadproducts = () => {
    import('../views/Products.vue')
}
const preloadsolutions = () => {
    import('../views/Solutions.vue')
}
const preloadresources = () => {
    import('../views/Resources.vue')
}
const preloadpricing = () => {
    import('../views/Pricing.vue')
}

import { ref, onUnmounted } from 'vue';

const show = ref();

const interval = setInterval(() => {
  show.value = !show;
}, 500);

</script>

<style scoped>
#headernavmain {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    margin-top: 0;
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
#headlink,
#signupbutton,
#demobutton,
#chimprankrouter {
    text-decoration: none;
}
#headlink {
    padding: 20px;
    color: #969696;
}
#signupbutton,
#demobutton {
    padding: 5px 10px;
    border-radius: 7px;
    margin: 2px;
}
#signupbutton {
    background-color: #00e199;
    color: #072c09;
}
#demobutton {
    background-color: #1f1f1f;
    color: #d8d8d8;
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
</style>
