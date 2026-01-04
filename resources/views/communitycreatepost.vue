<template>
    <form @submit.prevent="postsubmit(formdata)">
        <div id="formin">
            <label>title</label>
            <input
                type="text"
                name="title"
                v-model="formdata.title"
                class="textin"
            />
        </div>

        <div id="formin">
            <label>write content</label>
            <input
                type="text"
                name="content"
                v-model="formdata.content"
                class="textin"
            />
        </div>

        <div>
            <button type="submit" id="buttonsub">create post</button>
        </div>
    </form>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import { usePostStore } from "../js/Stores/PostHandling.js";
import { storeToRefs } from "pinia";

const { errors } = storeToRefs(usePostStore());
const { postsubmit } = usePostStore();

const formdata = reactive({
    title: "",
    content: "",
});

onMounted(() => (errors.value = {}));
</script>
