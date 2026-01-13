<template>
    <div id="comment">
        <p>{{ comment.content }}</p>
        <div id="authorname"><p @click="showuser" class="buttonb">{{ comment.author }}</p></div>
        <p>{{ comment.created_at }}</p>
        <p v-if="updated">updated</p>
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
    </div>
</template>

<script setup>
const props = defineProps({
    comment: {
        type: Object,
        required: true,
    },
});

import { useVoteStore } from "../js/Stores/VoteHandling.js";
import { storeToRefs } from "pinia";
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import thumbupon from "../components/images/icons/thumb-up-ON.svg";
import thumbupoff from "../components/images/icons/thumb-up-OFF.svg";
import thumbdownon from "../components/images/icons/thumb-down-ON.svg";
import thumbdownoff from "../components/images/icons/thumb-down-OFF.svg";

const router = useRouter();
const localvote = ref(props.comment?.uservote ?? null);
const localcounts = ref({
    up: props.comment?.upvote ?? 0,
    down: props.comment?.downvote ?? 0,
});
const updated = ref(props.comment.was_updated);
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
        await votesubmit(vote, "comments", props.comment.id);
    } catch {
        //rollback
        localvote.value = pastvote;
        localcounts.value = pastcount;
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


function showuser() {
    router.push({
        name: "thisuser",
        params: { handle: props.comment.handle },
    });
}

const { errors } = storeToRefs(useVoteStore());
const { votesubmit } = useVoteStore();

onMounted(() => (errors.value = {}));
</script>

<style scoped>
#comment {
    border: 3px solid;
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
#authorname{
    display: flex;
}
</style>
