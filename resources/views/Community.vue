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
            </aside>
            <div id="postswindow">

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
    overflow: scroll;
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
    min-width: 15%;
}

#postswindow {
    background-color: white;
}
</style>
