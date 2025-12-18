<template>
    <div id="comment">
        <p>{{ comment.content }}</p>
        <p>{{ comment.author.name }}</p>
        <div>
            <a @click="voting(1)">
                <img :src="thumbup">
                <p>{{ upvote }}</p>
            </a>

            <div id="voteratio">
                <div id="voteratiobar"></div>
            </div>

            <a @click="voting(-1)">
                <img :src="thumbdown">
            </a>
        </div>
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
import thumbupon from '../components/images/icons/thumb-up-ON.svg'
import thumbupoff from '../components/images/icons/thumb-up-OFF.svg'
import thumbdownon from '../components/images/icons/thumb-down-ON.svg'
import thumbdownoff from '../components/images/icons/thumb-down-OFF.svg'

const type = "comments"
const upvote = computed(() => localUpvote.value)
const thisuservote = computed(() => localUserVote.value)

const thumbup = ref(thumbupoff)
const thumbdown = ref(thumbdownoff)
const localUpvote = ref(props.comment?.upvotecount ?? 0)
const localDownvote = ref(props.comment?.downvotecount ?? 0)
const localUserVote = ref(props.comment?.uservote ?? null)

async function voting(vote) {
    const thisup = thumbup.value
    const thisdown = thumbdown.value
    const prevUpvote = localUpvote.value
    const prevDownvote = localDownvote.value
    const prevUserVote = localUserVote.value

    if (localUserVote.value != null) {
        if (vote == localUserVote.value) {
            if (localUserVote.value == 1) {
                localUpvote.value -= 1;
                thumbup.value = thumbupoff
            } else {
                localDownvote.value -= 1;
                thumbdown.value = thumbdownoff
            }
            localUserVote.value = null
        } else if (vote == 1) {
            localUpvote.value += 1;
            localDownvote.value -= 1;
            localUserVote.value = 1
            thumbup.value = thumbupon
            thumbdown.value = thumbdownoff
        } else if (vote == -1) {
            localUpvote.value -= 1;
            localDownvote.value += 1;
            localUserVote.value = -1
            thumbup.value = thumbupoff
            thumbdown.value = thumbdownon
        }
    } else {
        if (vote == 1) {
            localUpvote.value += 1;
            localUserVote.value = 1
            thumbup.value = thumbupon
        } else if (vote == -1) {
            localDownvote.value += 1;
            localUserVote.value = -1
            thumbdown.value = thumbdownon
        }
    }

    try {
        await votesubmit(vote, type, props.comment.id);
    } catch {
        localUpvote.value = prevUpvote;
        localDownvote.value = prevDownvote;
        localUserVote.value = prevUserVote;
        thumbup.value = thisup
        thumbdown.value = thisdown
    }
}

watch(thisuservote, (uvote) => {
    if (uvote == 1) {
        thumbup.value = thumbupon
        thumbdown.value = thumbdownoff
    } else if (uvote == -1) {
        thumbdown.value = thumbdownon
        thumbup.value = thumbupoff
    } else {
        thumbup.value = thumbupoff
        thumbdown.value = thumbdownoff
    }
})

let ratio = ref("50%")
const ratioupvote = computed(() => localUpvote.value)
const ratiodownvote = computed(() => localDownvote.value)


watch([ratioupvote, ratiodownvote], () => {
    ratio = ((ratioupvote.value + ratiodownvote.value) === 0
        ? 0.5 : ratioupvote.value / (ratioupvote.value + ratiodownvote.value)) * 100 + '%';
})

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

    height: v-bind(ratio);
}
</style>