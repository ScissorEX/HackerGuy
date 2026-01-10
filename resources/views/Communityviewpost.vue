<template>
    <div id="frame">
        <div id="loading" v-if="loading">
            <p>Loading</p>
        </div>
        <div v-if="error" class="error">{{ error }}</div>
        <div id="body" v-if="post">
            <div id="postheader">
                <h4>category: {{ post.category }}</h4>
                <h2>{{ post.title }}</h2>
                <div id="subheader">
                    <div id="tagcontainer">
                        <p v-for="tag in post.tags" id="tags">{{ tag }}</p>
                    </div>
                    <div id="datecontainer">
                        <p>{{ post.created_since }}</p>
                        <p v-if="updated">updated</p>
                        <div
                            v-if="
                                authStore.user &&
                                authStore.user.id === post.author_id
                            "
                        >
                            <div
                                class="button"
                                id="updatepost"
                                @click="openpostwindow"
                            >
                                update
                            </div>
                            <div
                                class="button"
                                id="deletepost"
                                @click="trydeletepost(post.id)"
                            >
                                delete
                            </div>
                        </div>
                        <div v-if="createpost">
                            <communitycreatepost
                                :patchtype="patchtype"
                                @closewindow="
                                    (payload) => {
                                        createpost = payload;
                                    }
                                "
                            ></communitycreatepost>
                        </div>
                    </div>
                </div>
                <div id="separator"></div>
            </div>

            <div id="contentcontainer">
                
                <p>{{ post.content }}</p>

                <h3>by {{ post.author }}</h3>

                <div id="votingcontainer">
                    <p>{{ localcounts.up }}</p>
                    <a @click="voting(1)">
                        <img :src="thumbup" />
                    </a>

                    <div id="voteratio">
                        <div id="voteratiobar"></div>
                    </div>

                    <a @click="voting(-1)">
                        <img :src="thumbdown" />
                    </a>
                </div>
                <div id="separator"></div>
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
import { useRoute, useRouter } from "vue-router";
import { usePostStore } from "../js/Stores/PostHandling.js";
import comcomment from "../components/communitycomment.vue";
import thumbupon from "../components/images/icons/thumb-up-ON.svg";
import thumbupoff from "../components/images/icons/thumb-up-OFF.svg";
import thumbdownon from "../components/images/icons/thumb-down-ON.svg";
import thumbdownoff from "../components/images/icons/thumb-down-OFF.svg";
import { useCommentStore } from "../js/Stores/CommentHandling.js";
import { useAuthStore } from "../js/Stores/AuthHandling.js";
import Communitycreatepost from "../components/communitycreatepost.vue";

const postStore = usePostStore();
const { commentsubmit } = useCommentStore();
const authStore = useAuthStore();

const commentdata = reactive({
    content: "",
});

const route = useRoute();
const router = useRouter();

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
        const data = await postStore.getPost(id);
        post.value = data;
        localvote.value = data.uservote ?? null;
        localcounts.value = {
            up: data.upvote ?? 0,
            down: data.downvote ?? 0,
        };
        updated.value = data.was_updated;
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

async function trydeletepost(id) {
    error.value = post.value = null;
    loading.value = true;

    try {
        console.log();
        await postStore.postdelete(id);
        router.back();
    } catch (err) {
        error.value = err.toString();
    } finally {
        loading.value = false;
    }
}

const createpost = ref(false);
const patchtype = ref(null);

function openpostwindow() {
    createpost.value = !createpost.value;
    patchtype.value = "update post";
}

const { errors } = storeToRefs(useVoteStore());
const { votesubmit } = useVoteStore();

onMounted(() => (errors.value = {}));
</script>

<style scoped>
#frame {
    display: flex;
    width: 100%;
}
#body {
    width: 100%;
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
    margin: auto 6px;
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
#deletepost {
    background-color: rgb(240, 91, 91);
    color: black;
    border-radius: 8px;
    padding: 3px 10px;
    align-content: center;
}
#updatepost {
    background-color: rgb(90, 179, 116);
    color: black;
    border-radius: 8px;
    padding: 3px 10px;
    align-content: center;
}
#votingcontainer{
    display: flex;
    align-items: flex-end;
}
</style>
