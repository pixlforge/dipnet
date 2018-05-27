<template>
  <div class="comments__input-group">
    <div class="comments__avatar">
      <img
        v-if="avatarPath !== ''"
        :src="avatarPath"
        alt="Avatar de l'utilisateur">
      <img
        v-else
        :src="'/' + randomAvatar"
        alt="Avatar de l'utilisateur">
    </div>
    <textarea
      v-model="comment.body"
      type="text"
      class="comments__textarea"
      placeholder="Votre commentaire ici..."/>
    <button
      class="btn btn--red"
      role="button"
      @click="addComment">
      <i class="fal fa-paper-plane"/>
      Envoyer
    </button>
  </div>
</template>

<script>
import mixins from "../../mixins";

export default {
  mixins: [mixins],
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
        body: ""
      },
      errors: {}
    };
  },
  methods: {
    addComment() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("comments.store", [this.business.id]), this.comment)
        .then(response => {
          this.$store.dispatch("toggleLoader");
          this.$emit("postedComment", {
            id: response.data.id,
            body: this.comment.body
          });
          this.comment.body = "";
          this.errors = {};
        })
        .catch(error => {
          this.$store.dispatch("toggleLoader");
          this.errors = error.response.data;
        });
    }
  }
};
</script>