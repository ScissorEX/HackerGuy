<script setup>
import logincomp from '../components/logincomp.vue';
import signupcomp from '../components/signupcomp.vue';
import { onMounted, onUnmounted, reactive, ref } from 'vue';
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
        <div id="div60">
                <img @click="$router.back()" src="../components/images/icons/monkey.svg" style="width: 250px;"/>

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
</template>

<style scoped>
#div60 {
    width: 100dvw;
    height: 100dvh;
    background-image: url(../components/images/Wave.svg),
    linear-gradient(#223348 50%, #72abf2 50%);
    background-repeat: no-repeat;
    background-size: contain;
    background-position: 50%;
    
}
#logo {
    padding: 50px;
    display: flex;
    justify-self: center;
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
