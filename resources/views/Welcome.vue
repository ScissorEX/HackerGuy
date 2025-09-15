<template>
    <headernav></headernav>
    <router-view name="Home"></router-view>
    <router-view></router-view>
</template>

<script setup>
import headernav from '../components/headernav.vue';
</script>

<style scoped>
</style>
