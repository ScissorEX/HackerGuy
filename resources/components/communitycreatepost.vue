<template>
    <div
        id="createpostcover"
        @mousedown.self="mouseleave = true"
        @mouseup.self="mouseleaveactivate"
    >
        <div id="body">
            <div id="barupthere">
                <h2>{{ props.patchtype }}</h2>
                <a
                    @click="$emit('closewindow', false)"
                    id="closebutton"
                    class="button"
                >
                    <img src="./images/icons/close.svg" width="30px" />
                </a>
            </div>
            <form @submit.prevent="postpatch()" style="height: 100%">
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
                    <select
                        id="category"
                        name="category"
                        v-model="formdata.category_id"
                    >
                        <option :value="1">General</option>
                    </select>
                </div>

                <div>
                    <button type="submit" id="buttonsub">
                        {{ props.patchtype }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, onMounted, ref } from "vue";
import { usePostStore } from "../js/Stores/PostHandling.js";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const route = useRoute();

const { errors } = storeToRefs(usePostStore());
const postStore = usePostStore();
const postId = route.params.id;
const mouseleave = ref(false);
const emit = defineEmits(["closewindow"]);
const formdata = reactive({
    title: "",
    content: "",
    category_id: null,
    tags: [],
});

const props = defineProps({
    patchtype: {
        type: String,
        required: true,
    },
});

function mouseleaveactivate() {
    if (mouseleave.value == true) {
        emit("closewindow", false);
    }
    mouseleave.value = false;
}

async function postpatch() {
    if (props.patchtype == "Create post") {
        await postStore.postsubmit(formdata);
    } else if (props.patchtype == "Update post") {
        await postStore.postupdate(formdata, postId);
    } else {
        return console.log("error : postpatch() at communitycreatepost");
    }
    window.location.reload();
}
onMounted(() => (errors.value = {}));
</script>

<style scoped>
#createpostcover {
    z-index: 10;
    background-color: rgba(0, 0, 0, 0.25);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
#body {
    position: relative;
    z-index: 12;
    width: 600px;
    height: 600px;
    background-color: cadetblue;
}
#formin {
    display: flex;
}
#closebutton {
    background-color: red;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    overflow: hidden;
}
#barupthere {
    display: flex;
    justify-content: space-between;
    padding: 10px;
}
</style>
