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
    <div
      v-if="!currentComments.length"
      class="main__no-results main__no-results--small">
      <p>
        Aucun commentaire en rapport avec cette affaire n'a encore été posté pour le moment.<br>
        Soyez le premier!
      </p>
      <IllustrationTakingNotes/>
    </div>
  </div>
</template>

<script>
import Comment from "./Comment";
import AddComment from "./AddComment";
import IllustrationTakingNotes from "../illustrations/IllustrationTakingNotes";

export default {
  components: {
    Comment,
    AddComment,
    IllustrationTakingNotes
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