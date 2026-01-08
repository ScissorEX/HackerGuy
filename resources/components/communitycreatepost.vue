<template>
    <form @submit.prevent="postsubmit(formdata)">
        <div id="formin">
            <label for="title">title</label>
            <input
                type="text"
                name="title"
                v-model="formdata.title"
                class="textin"
            />
        </div>

        <div id="formin">
            <label for="content">write content</label>
            <input
                type="text"
                name="content"
                v-model="formdata.content"
                class="textin"
            />
        </div>

        <div id="formin">
            <label for="category">write content</label>
            <select
                name="category"
                v-model="formdata.category"
                class="textin"
            >
                <option value="general">General</option>
            </select>
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
    category: "",
});

onMounted(() => (errors.value = {}));
</script>
