<template>
    <div id="bgc">
        <communityhead></communityhead>
        <div id="body">
            <aside id="aside">
                <div>
                    <router-link to="/community" class="button">
                        <img
                            alt="house"
                            src="../components/images/icons/home.svg"
                        />
                        Home
                    </router-link>
                </div>
            </aside>
            <div id="postswindow">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script setup>
import communityhead from "../components/communityhead.vue";
</script>

<style scoped>
#bgc {
    height: 100dvh;
    display: flex;
    flex-direction: column;
    background-color: oklch(0.4 0.1 210);
    overflow: hidden;
}

#body {
    max-width: 1200px;
    width: 100%;
    background: none;
    display: flex;
    flex: 1;
    margin: 0 auto;
    min-height: 0;
}

#aside {
    background-color: oklch(0.6 0.1 210);
    min-width: 15%;
    flex-shrink: 0;
    overflow-y: auto;
}

#postswindow {
    background-color: white;
    flex: 1;
    overflow-y: auto;
    min-height: 0;
}
</style>
