<template>
  <div class="comments__input-group">
    <div class="comments__avatar">
      <img :src="'/' + dataAvatarPath" alt="Avatar de l'utilisateur" v-if="dataAvatarPath !== ''">
      <img :src="'/' + dataRandomAvatar" alt="Avatar de l'utilisateur" v-else>
    </div>
    <textarea type="text"
              class="comments__textarea"
              v-model="comment.body"></textarea>
    <button class="btn btn--red" @click="addComment">
      <i class="fal fa-paper-plane"></i>
      Envoyer
    </button>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    props: [
      'data-business',
      'data-avatar-path',
      'data-random-avatar',
    ],
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

        axios.post(route('comments.store', [this.dataBusiness.id]), this.comment)
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