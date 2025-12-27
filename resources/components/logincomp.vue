<template>
    <div>
        <form @submit.prevent="formsubmit('login', formdata)" id="formdiv">
            <div id="formin">
                <label>type your email adress</label>
                <input type="text" name="email" v-model="formdata.email" class="textin" />
            </div>
        
            <div id="formin">
                <label>type your password</label>
                <input type="password" name="password" v-model="formdata.password" class="textin" />
            </div>
        
            <div>
                <button type="submit" id="buttonsub">Sign in</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue';
import { useAuthStore } from '../js/Stores/AuthHandling.js';
import { storeToRefs } from 'pinia';

const { errors } = storeToRefs(useAuthStore());
const { formsubmit } = useAuthStore();

const formdata = reactive({
    email: '',
    password: '',
});

onMounted(() => (errors.value = {}));
</script>
