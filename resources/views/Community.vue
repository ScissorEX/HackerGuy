<template>
    <div style="height: 100dvh; display: flex; flex-direction: column;">
        <communityhead></communityhead>
        <div id="body">
            <aside id="aside">
                <div>
                    <router-link to="/community" class="button">
                        <img alt="house" src="../components/images/icons/home.svg"/>
                        Home</router-link
                    >
                </div>
                <div></div>
            </aside>
            <div id="content">the content of the post or post on subed channels</div>
        </div>
    </div>
</template>

<script setup>
import communityhead from '../Community/communityhead.vue';
</script>

<style scoped>
#body {
    background-color: blue;
    max-width: 1200px;
    width: 100%;
    background: none;
    display: flex;
    justify-content: space-between;
    margin: 0 auto;
    height: 100%;
}
#content {
    background-color: chartreuse;
    width: 100%;
}
#aside {
    background-color: aqua;
    width: 25%;
}
</style>
