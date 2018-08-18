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
    
    <!-- Send button -->
    <Button
      primary
      red
      @click.prevent="addComment">
      <i class="fal fa-paper-plane"/>
      Envoyer
    </Button>
  </div>
</template>

<script>
import Button from "../buttons/Button";

import { mapActions } from "vuex";

export default {
  components: {
    Button
  },
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
    ...mapActions(["toggleLoader"]),
    async addComment() {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route("comments.store", [this.business.reference]),
          this.comment
        );
        this.$emit("comment:posted", {
          id: res.data.id,
          body: this.comment.body
        });
        this.comment.body = "";
        this.errors = {};
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>