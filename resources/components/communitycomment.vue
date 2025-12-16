<template>
    <div id="comment">
        <p>{{ comment.content }}</p>
        <p>{{ comment.author.name }}</p>
        <h4>upvotes {{ upvote }} | {{ downvote }} downvotes</h4>
        <button @click="voting(1)"> upvote</button>
        <button @click="voting(-1)"> downvote</button>
    </div>
</template>

<script setup>
const props = defineProps({
    comment: {
        type: Object,
        required: true
    }
});

import { useVoteStore } from '../js/Stores/VoteHandling.js';
import { storeToRefs } from 'pinia';
import { ref, watch, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'


const route = useRoute()

const type = "comments"
const upvote = computed(() => props.comment.upvotecount)
const downvote = computed(() => props.comment.downvotecount)

async function voting(vote) {
    if (props.comment.uservote != null) {
        if (vote == props.comment.uservote) {
            if (props.comment.uservote == 1) {
                props.comment.upvotecount += -1;
            } else {
                props.comment.downvotecount += -1;
            }
        } else if (vote == 1) {
            props.comment.upvotecount += 1;
            props.comment.downvotecount += -1;
        } else if (vote == -1) {
            props.comment.upvotecount += -1;
            props.comment.downvotecount += 1;
        }
    } else {
        if (vote == 1) {
            props.comment.upvotecount += 1;
        } else {
            props.comment.downvotecount += 1;
        }
    }

    try {
        await votesubmit(vote, type, props.comment.id);
    } catch {
        props.comment.upvotecount = upvote;
        props.comment.downvotecount = downvote;
    }
}

const { errors } = storeToRefs(useVoteStore());
const { votesubmit } = useVoteStore();

onMounted(() => (errors.value = {}));
</script>

<style scoped>
#comment {
    border: 3px solid;
}
</style>