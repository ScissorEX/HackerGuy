<template>

  <div>
    <div v-if="loading">Loading</div>
    <div v-if="error" class="error">{{ error }}</div>
    <div id="body" v-if="post">
      <h2>{{ post.title }}</h2>
      <p>{{ post.content }}</p>
      <p>{{ post.comments.length }} comments</p>
      <h3>by {{ post.author.name }}</h3>

      <div>
        <a @click="voting(1)">
          <img :src=thumbup>
          <p>{{ upvote }}</p>
        </a>

        <div id="voteratio">
          <div id="voteratiobar"></div>
        </div>

        <a @click="voting(-1)">
          <img :src=thumbdown>
        </a>
      </div>

      <form @submit.prevent="commentsubmit(post.id, commentdata)">
        <input placeholder="comment" v-model="commentdata.content">
        <button>submit</button>
      </form>

      <div>
        <comcomment v-for="comment in post.comments" :key="comment.id" :comment="comment"></comcomment>
      </div>

    </div>
  </div>
</template>

<script setup>
import { useVoteStore } from '../js/Stores/VoteHandling.js';
import { storeToRefs } from 'pinia';
import { ref, watch, computed, onMounted, reactive } from 'vue'
import { useRoute } from 'vue-router'
import { usePostStore } from '../js/Stores/PostHandling.js'
import comcomment from '../components/communitycomment.vue';
import thumbupon from '../components/images/icons/thumb-up-ON.svg'
import thumbupoff from '../components/images/icons/thumb-up-OFF.svg'
import thumbdownon from '../components/images/icons/thumb-down-ON.svg'
import thumbdownoff from '../components/images/icons/thumb-down-OFF.svg'
import { useCommentStore } from '../js/Stores/CommentHandling.js';

const { getPost } = usePostStore();
const { commentsubmit } = useCommentStore()

const commentdata = reactive({
  content: '',
});

const route = useRoute()

const loading = ref(false)
const post = ref(null)
const error = ref(null)
const type = "posts"
const upvote = computed(() => post.value?.upvotecount ?? 0)
const downvote = computed(() => post.value?.downvotecount ?? 0)
const thisuservote = computed(() => post.value?.uservote ?? null)
const thumbup = ref(thumbupoff)
const thumbdown = ref(thumbdownoff)


//optimistic voting
async function voting(vote) {
  const thisup = thumbup.value
  const thisdown = thumbdown.value
  if (post.value.uservote != null) {
    if (vote == post.value.uservote) {
      if (post.value.uservote == 1) {
        post.value.upvotecount += -1;
        thumbup.value = thumbupoff
      } else {
        post.value.downvotecount += -1;
        thumbdown.value = thumbdownoff
      }
      post.value.uservote = null;
    } else if (vote == 1) {
      post.value.upvotecount += 1;
      post.value.downvotecount += -1;
      post.value.uservote = 1;
      thumbup.value = thumbupon
      thumbdown.value = thumbdownoff
    } else if (vote == -1) {
      post.value.upvotecount += -1;
      post.value.downvotecount += 1;
      post.value.uservote = -1;
      thumbup.value = thumbupoff
      thumbdown.value = thumbdownon
    }
  } else {
    if (vote == 1) {
      post.value.upvotecount += 1;
      post.value.uservote = 1;
      thumbup.value = thumbupon
    } else if (vote == -1) {
      post.value.downvotecount += 1;
      post.value.uservote = -1
      thumbdown.value = thumbdownon
    }
  }

  try {
    await votesubmit(vote, type, post.value.id);
  } catch {
    post.value.upvotecount = upvote.value;
    post.value.downvotecount = downvote.value;
    thumbup.value = thisup
    thumbdown.value = thisdown
  }
}


//fetch data of the post
watch(() => route.params.id, fetchdata, { immediate: true })

async function fetchdata(id) {
  error.value = post.value = null
  loading.value = true

  try {
    const data = await getPost(id)
    post.value = data
  } catch (err) {
    error.value = err.toString()
  } finally {
    loading.value = false
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
let ratio = ref()
const ratioupvote = computed(() => post.value?.upvotecount ?? null)
const ratiodownvote = computed(() => post.value?.downvotecount ?? null)
watch([ratioupvote, ratiodownvote], () => {
  ratio = ((ratioupvote.value + ratiodownvote.value) === 0
    ? 0.5 : ratioupvote.value / (ratioupvote.value + ratiodownvote.value)) * 100 + '%';
})

const { errors } = storeToRefs(useVoteStore());
const { votesubmit } = useVoteStore();

onMounted(() => (errors.value = {}));
</script>

<style scoped>
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