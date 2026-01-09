<template>
    <form @submit.prevent="postsubmit(formdata)">
        <div id="formin">
            <label for="title">title</label>
            <input
                id="title"
                type="text"
                name="title"
                v-model="formdata.title"
            />
        </div>

        <div id="formin">
            <label for="content">write content</label>
            <input
                id="content"
                type="text"
                name="content"
                v-model="formdata.content"
            />
        </div>

        <div id="formin">
            <label for="category">category</label>
            <select id="category" name="category" v-model="formdata.category_id">
                <option :value="1">General</option>
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
    category_id: null,
    tags: []
});

onMounted(() => (errors.value = {}));
</script>

<style scoped>
    #formin{
        display: flex;
        
    }
</style>
