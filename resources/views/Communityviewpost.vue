<template>
    <div id="frame">
        <div id="loading" v-if="loading">
            <p>Loading</p>
        </div>
        <div v-if="error" class="error">{{ error }}</div>
        <div id="body" v-if="post">
            <div id="postheader">
                <h2>{{ post.title }}</h2>
                <div id="subheader">
                    <div id="tagcontainer">
                        <p v-for="tag in post.tags" id="tags">{{ tag }}</p>
                    </div>
                    <div id="datecontainer">
                        <p>{{ post.created_since }}</p>
                        <p v-if="updated">updated</p>
                    </div>
                </div>
                <div id="separator"></div>
            </div>

            <div id="contentcontainer">
                <h4>{{ post.category }}</h4>
                <p>{{ post.content }}</p>

                <h3>by {{ post.author }}</h3>

                <div>
                    <a @click="voting(1)">
                        <img :src="thumbup" />
                        <p>{{ localcounts.up }}</p>
                    </a>

                    <div id="voteratio">
                        <div id="voteratiobar"></div>
                    </div>

                    <a @click="voting(-1)">
                        <img :src="thumbdown" />
                    </a>
                </div>
                <p>{{ post.comments.length }} comments</p>
                <form @submit="commentsubmit(post.id, commentdata)">
                    <input
                        placeholder="comment"
                        v-model="commentdata.content"
                    />
                    <button>submit</button>
                </form>
            </div>

            <div>
                <comcomment
                    v-for="comment in post.comments"
                    :key="comment.id"
                    :comment="comment"
                ></comcomment>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useVoteStore } from "../js/Stores/VoteHandling.js";
import { storeToRefs } from "pinia";
import { ref, watch, computed, onMounted, reactive } from "vue";
import { useRoute } from "vue-router";
import { usePostStore } from "../js/Stores/PostHandling.js";
import comcomment from "../components/communitycomment.vue";
import thumbupon from "../components/images/icons/thumb-up-ON.svg";
import thumbupoff from "../components/images/icons/thumb-up-OFF.svg";
import thumbdownon from "../components/images/icons/thumb-down-ON.svg";
import thumbdownoff from "../components/images/icons/thumb-down-OFF.svg";
import { useCommentStore } from "../js/Stores/CommentHandling.js";

const { getPost } = usePostStore();
const { commentsubmit } = useCommentStore();

const commentdata = reactive({
    content: "",
});

const route = useRoute();

const loading = ref(false);
const post = ref(null);
const error = ref(null);

const updated = ref(true);

const localvote = ref(null);
const localcounts = ref({ up: 0, down: 0 });

async function voting(vote) {
    const pastvote = localvote.value;
    const pastcount = { ...localcounts.value };

    if (pastvote == vote) {
        localvote.value = null;
        localcounts.value[vote == 1 ? "up" : "down"]--;
    } else {
        if (pastvote != null) {
            localcounts.value[pastvote == 1 ? "up" : "down"]--;
        }
        localvote.value = vote;
        localcounts.value[vote == 1 ? "up" : "down"]++;
    }

    try {
        await votesubmit(vote, "posts", post.value.id);
    } catch {
        //rollback
        localvote.value = pastvote;
        localcounts.value = pastcount;
    }
}

//fetch data of the post
watch(() => route.params.id, fetchdata, { immediate: true });

async function fetchdata(id) {
    error.value = post.value = null;
    loading.value = true;

    try {
        const data = await getPost(id);
        post.value = data;
        localvote.value = data.uservote ?? null;
        localcounts.value = {
            up: data.upvote ?? 0,
            down: data.downvote ?? 0,
        };
        //updated.value = data.was_updated
    } catch (err) {
        error.value = err.toString();
    } finally {
        loading.value = false;
    }
}

const thumbup = computed(() => (localvote.value == 1 ? thumbupon : thumbupoff));
const thumbdown = computed(() =>
    localvote.value == -1 ? thumbdownon : thumbdownoff,
);
const ratio = computed(() => {
    const { up, down } = localcounts.value;
    const total = up + down;
    return total == 0 ? "50%" : `${(up / total) * 100}%`;
});

const { errors } = storeToRefs(useVoteStore());
const { votesubmit } = useVoteStore();

onMounted(() => (errors.value = {}));
</script>

<style scoped>
#frame {
    display: flex;
}

#loading {
    justify-items: center;
    width: 100%;
}

#voteratio {
    width: 7px;
    height: 50px;
    background-color: rgb(69, 66, 238);
    border-radius: 3px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

#voteratiobar {
    background-color: rgb(204, 51, 31);
    border-radius: 3px 3px 0 0;

    height: v-bind("ratio");
}

#postheader,
#contentcontainer {
    padding: 20px;
}

#separator {
    background-color: #d8d8d8;
    height: 2px;
    margin: 5px 0;
    width: 80%;
    justify-self: center;
}

#subheader {
    display: flex;
    justify-content: space-between;
}

#tagcontainer,
#datecontainer {
    display: flex;
    flex-grow: 1;
    align-content: center;
    justify-content: center;
}

#tags {
    border: #d8d8d8 solid;
    padding: 5px;
    margin: 10px;
    border-radius: 10px;
    min-width: 80px;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}

p {
    margin: 10px;
}
</style>
