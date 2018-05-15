<template>
  <div class="comments__input-group">
    <div class="comments__avatar">
      <img :src="'/' + avatarPath" alt="Avatar de l'utilisateur" v-if="avatarPath !== ''">
      <img :src="'/' + randomAvatar" alt="Avatar de l'utilisateur" v-else>
    </div>
    <textarea type="text"
              class="comments__textarea"
              v-model="comment.body"
              placeholder="Votre commentaire ici..."></textarea>
    <button class="btn btn--red"
            role="button"
            @click="addComment">
      <i class="fal fa-paper-plane"></i>
      Envoyer
    </button>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    props: {
      business: {
        type: Object,
        required: true
      },
      avatarPath: {
        type: String,
        required: true
      },
      randomAvatar: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        comment: {
          body: '',
        },
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      addComment() {
        this.$store.dispatch('toggleLoader')
        axios.post(route('comments.store', [this.business.id]), this.comment)
          .then(response => {
            this.$store.dispatch('toggleLoader')
            this.$emit('postedComment', {
              id: response.data.id,
              body: this.comment.body
            })
            this.comment.body = ''
            this.errors = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data
          })
      }
    }
  }
</script>