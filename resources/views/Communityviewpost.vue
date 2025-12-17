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

        <a @click="voting(-1)">
          <img :src=thumbdown>
          <p>{{ downvote }}</p>
        </a>
      </div>

      <form @submit.prevent="commentsubmit(post.id, commentdata)">
        <input placeholder="comment" v-model="commentdata.content">
        <button>submit</button>
      </form>


      <comcomment v-for="comment in post.comments" :key="comment.id" :comment="comment"></comcomment>
    </div>
  </div>
</template>

<script setup>
import { useVoteStore } from '../js/Stores/VoteHandling.js';
import { storeToRefs } from 'pinia';
import { ref, watch, computed, onMounted,reactive } from 'vue'
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
const upvote = computed(() => post.value.upvotecount)
const downvote = computed(() => post.value.downvotecount)
let thumbup = thumbupoff
let thumbdown = thumbdownoff


//optimistic voting
async function voting(vote) {
  const thisup = thumbup
  const thisdown = thumbdown
  if (post.value.uservote != null) {
    if (vote == post.value.uservote) {
      if (post.value.uservote == 1) {
        post.value.upvotecount += -1;
        thumbup = thumbupoff
      } else {
        post.value.downvotecount += -1;
        thumbdown = thumbdownoff
      }
      post.value.uservote = null;
    } else if (vote == 1) {
      post.value.upvotecount += 1;
      post.value.downvotecount += -1;
      post.value.uservote = 1;
      thumbup = thumbupon
      thumbdown = thumbdownoff
    } else if (vote == -1) {
      post.value.upvotecount += -1;
      post.value.downvotecount += 1;
      post.value.uservote = -1;
      thumbup = thumbupoff
      thumbdown = thumbdownon
    }
  } else {
    if (vote == 1) {
      post.value.upvotecount += 1;
      post.value.uservote = 1;
      thumbup = thumbupon
    } else {
      post.value.downvotecount += 1;
      post.value.uservote = -1
      thumbdown = thumbdownon
    }
  }

  try {
    await votesubmit(vote, type, post.value.id);
  } catch {
    post.value.upvotecount = upvote.value;
    post.value.downvotecount = downvote.value;
    thumbup = thisup
    thumbdown = thisdown
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
const thisuservote = computed(() => post.value?.uservote ?? null)
watch(thisuservote, (uvote) => {
  if (uvote == 1) {
    thumbup = thumbupon
  } else if (uvote == -1) {
    thumbdown = thumbdownon
  }
})


const { errors } = storeToRefs(useVoteStore());
const { votesubmit } = useVoteStore();

onMounted(() => (errors.value = {}));
</script>

<style scoped></style>