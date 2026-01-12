<template>
    <div id="avatar" @click="dropdownmenu = !dropdownmenu">
        <img
            src="/resources/components/images/icons/avatar.svg"
            style="width: 35px"
        />
        <div v-if="dropdownmenu" id="dropdownmenu" class="button">
            <span @click="showuser" class="button" style="color: black"
                >profile</span
            >
            <br />
            <span @click="authStore.logout()"> log out</span>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "../js/Stores/AuthHandling";
import { useRouter } from "vue-router";
const router = useRouter();
const authStore = useAuthStore();
const dropdownmenu = ref(false);

function showuser() {
    router.push({
        name: "thisuser",
        params: { handle: authStore.user.handle },
    });
}
</script>

<style scoped>
#avatar {
    background-color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
}
#dropdownmenu {
    position: relative;
    background-color: rgb(207, 207, 207);
    width: 100px;
    color: black;
    border: solid black;
    border-width: 1px;
}
</style>
