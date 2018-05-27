<template>
  <div class="comments__container">
    <div class="comments__avatar">
      <img
        v-if="comment.user.avatar"
        :src="avatarPath"
        alt="L'image de profil de l'utilisateur">
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
import moment from "moment";
import mixins from "../../mixins";

export default {
  mixins: [mixins],
  props: {
    comment: {
      type: Object,
      required: true
    }
  },
  computed: {
    avatarPath() {
      return "/storage/avatar" + this.comment.user.avatar.path;
    }
  },
  methods: {
    getDate(date) {
      return moment(date)
        .locale(this.momentLocale)
        .fromNow();
    }
  }
};
</script>