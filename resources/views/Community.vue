<template>
    <div id="bgc">
        <communityhead></communityhead>
        <div id="body">
            <aside id="aside">
                <div>
                    <router-link to="/community" class="button">
                        <img alt="house" src="../components/images/icons/home.svg" />
                        Home</router-link>
                </div>
                <div></div>
            </aside>
            <div id="t">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script setup>
import communityhead from '../components/communityhead.vue';
</script>

<style scoped>
#bgc {
    height: 100dvh;
    display: flex;
    flex-direction: column;
    background-color: cornflowerblue;
}

#body {
    max-width: 1200px;
    width: 100%;
    background: none;
    display: flex;
    justify-content: space-between;
    margin: 0 auto;
    height: 100%;
}

#aside {
    background-color: aqua;
    width: 25%;
}

#t {
    background-color: white;
}
</style>
