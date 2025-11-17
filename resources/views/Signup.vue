<script setup>
import logincomp from '../components/logincomp.vue';
import signupcomp from '../components/signupcomp.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import { useAuthStore } from '../js/Stores/AuthHandling.js';
import { storeToRefs } from 'pinia';

const { errors } = storeToRefs(useAuthStore());
const { logout } = useAuthStore();

onMounted(() => (errors.value = {}));
const tologin = ref(true);

onMounted(() => {
    document.body.style.backgroundColor = 'black';
    document.body.style.color = 'white';
});
onUnmounted(() => {
    document.body.style.backgroundColor = '';
    document.body.style.color = '';
});
</script>

<template>
    <div>
        <div id="div60">
            <div id="logo">
                <img src="../components/images/monkey.svg" style="width: 100%" />
            </div>

            <div v-if="tologin">
                <signupcomp></signupcomp>
                <div>
                    <p style="justify-self: center">Already have an account?</p>
                    <button @click="tologin = !tologin" id="buttonswitch">Sign in instead</button>
                </div>
            </div>

            <div v-if="!tologin">
                <logincomp></logincomp>
                <button @click="tologin = !tologin" id="buttonswitch">Back to Sign Up</button>
            </div>
            <form @submit.prevent="logout()">
                <button type="submit"></button>
            </form>
        </div>
    </div>
</template>

<style scoped>
#div60 {
    border: solid #408040;
    border-width: 0px 3px;
    box-shadow:
        10px 0px 40px 10px rgba(83, 227, 147, 0.25),
        -10px 0px 40px 10px rgba(83, 227, 147, 0.25);
    width: max(60vw, 500px);
    justify-self: center;
    height: 100vh;
}
#logo {
    justify-self: center;
    width: 200px;
    padding: 50px;
}
#formdiv {
    height: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 30px;
}
:deep(#formin) {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 80%;
    max-width: 300px;
    gap: 8px;
}
:deep(.textin) {
    width: 100%;
    padding: 5px;
    font-size: 1rem;
}
:deep(#buttonsub) {
    width: 80px;
    height: 30px;
    font-size: 1rem;
}
#buttonswitch {
    display: flex;
    padding: 10px;
    font-size: 1rem;
    border-radius: 25px;
    justify-self: center;
}
</style>
