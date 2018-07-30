<template>
  <div>
    <h2 class="comments__title">Commentaires</h2>
    <AddComment
      :business="business"
      :avatar-path="avatarPath"
      :random-avatar="randomAvatar"
      @comment:posted="addComment"/>
    <transition-group name="highlight">
      <Comment
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
import Comment from "./Comment";
import AddComment from "./AddComment";

export default {
  components: {
    Comment,
    AddComment
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