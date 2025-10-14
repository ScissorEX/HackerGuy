<template>
    <form @submit.prevent="formsubmit('signup', formdata)" id="formdiv">
        <div id="formin">
            <label>type your name</label>
            <input type="text" name="name" v-model="formdata.name" class="textin" />
        </div>

        <div id="formin">
            <label>type your email adress</label>
            <input type="text" name="email" v-model="formdata.email" class="textin" />
        </div>

        <div id="formin">
            <label>type your password</label>
            <input type="password" name="password" v-model="formdata.password" class="textin" />
        </div>

        <div id="formin">
            <label>confirm your password</label>
            <input
                type="password"
                name="password_confirmation"
                v-model="formdata.password_confirmation"
                class="textin" />
        </div>

        <div>
            <button type="submit" id="buttonsub">Sign up</button>
        </div>
    </form>
</template>

<script setup>
import { reactive, onMounted } from 'vue';
import { useAuthStore } from '../js/Stores/AuthHandling.js';
import { storeToRefs } from 'pinia';

const { errors } = storeToRefs(useAuthStore());
const { formsubmit } = useAuthStore();

const formdata = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

onMounted(() => (errors.value = {}));
</script>

<style scoped></style>
