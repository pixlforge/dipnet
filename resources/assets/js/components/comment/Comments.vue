<template>
  <div>
    <h2 class="comments__title">Commentaires</h2>
    <add-comment
      :business="business"
      :avatar-path="avatarPath"
      :random-avatar="randomAvatar"
      @postedComment="addComment"/>
    <transition-group name="highlight">
      <comment
        v-for="comment in currentComments"
        :key="comment.id"
        :comment="comment"/>
    </transition-group>
    <p
      v-if="!currentComments.length"
      class="paragraph__no-model-found paragraph__no-model-found--small">
      Aucun commentaire n'a été posté pour le moment.
    </p>
  </div>
</template>

<script>
import AddComment from "./AddComment";
import Comment from "./Comment";

export default {
  components: {
    AddComment,
    Comment
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
    },
    comments: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentComments: this.comments
    };
  },
  methods: {
    addComment(comment) {
      const newComment = {
        id: comment.id,
        body: comment.body,
        user: this.user
      };
      this.currentComments.unshift(newComment);
      window.flash({
        message: "Votre commentaire a bien été posté!",
        level: "success"
      });
    }
  }
};
</script>