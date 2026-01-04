<template>
    <headernav></headernav>
    <router-view></router-view>
</template>

<script setup>
import { onMounted, onUnmounted } from "vue";
import headernav from "../components/headernav.vue";

onMounted(() => {
    document.body.style.backgroundColor = "black";
    document.body.style.color = "white";
});
onUnmounted(() => {
    document.body.style.backgroundColor = "";
    document.body.style.color = "";
});
</script>

<style scoped></style>
