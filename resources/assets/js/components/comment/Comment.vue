<template>
  <div class="comments__container">
    <div class="comments__avatar">
      <img :src="avatarPath" alt="L'image de profil de l'utilisateur" v-if="comment.user.avatar">
    </div>
    <div class="comments__content">
      <div class="comments__meta">
        <h3>{{ comment.user.username }}</h3>
        <span>{{ getDate(comment.created_at) }}</span>
      </div>
      <p>{{ comment.body }}</p>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: {
      comment: {
        type: Object,
        required: true
      }
    },
    computed: {
      avatarPath() {
        return '/img/avatar' + this.comment.user.avatar.path
      }
    },
    mixins: [mixins],
    methods: {
      getDate(date) {
        return moment(date).locale(this.momentLocale).fromNow()
      }
    }
  }
</script>