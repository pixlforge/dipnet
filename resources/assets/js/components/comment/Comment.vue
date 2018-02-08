<template>
  <div class="comments__container">
    <div class="comments__avatar">
      <img :src="avatarPath" alt="L'image de profile de l'utilisateur" v-if="dataComment.user.avatar">
    </div>
    <div class="comments__content">
      <div class="comments__meta">
        <h3>{{ dataComment.user.username }}</h3>
        <span>{{ getDate(dataComment.created_at) }}</span>
      </div>
      <p>{{ dataComment.body }}</p>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: [
      'data-comment'
    ],
    mixins: [mixins],
    computed: {
      avatarPath() {
        return '/img/avatar' + this.dataComment.user.avatar.path
      }
    },
    methods: {
      /**
       * Get the formatted dates.
       */
      getDate(date) {
        return moment(date).locale(this.momentLocale).fromNow()
      }
    }
  }
</script>