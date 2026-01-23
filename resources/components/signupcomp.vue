<template>
    <div>
        <form @submit.prevent="logsubmit('signup', formdata)" id="formdiv">
            <div id="formin">
                <label for="name">type your name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    autocomplete="no"
                    v-model="formdata.name"
                    class="forminput"
                />
            </div>

            <div id="formin">
                <label for="email">type your email adress</label>
                <input
                    type="text"
                    name="email"
                    id="email"
                    autocomplete="no"
                    v-model="formdata.email"
                    class="forminput"
                />
            </div>

            <div id="formin">
                <label for="password">type your password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    v-model="formdata.password"
                    class="forminput"
                />
            </div>

            <div id="formin">
                <label for="passwordconf">confirm your password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="passwordconf"
                    v-model="formdata.password_confirmation"
                    class="forminput"
                />
            </div>

            <div>
                <button type="submit" id="buttonsub">Sign up</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import { useAuthStore } from "../js/Stores/AuthHandling.js";
import { storeToRefs } from "pinia";

const { errors } = storeToRefs(useAuthStore());
const { logsubmit } = useAuthStore();

const formdata = reactive({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

onMounted(() => (errors.value = {}));
</script>

<style scoped></style>
