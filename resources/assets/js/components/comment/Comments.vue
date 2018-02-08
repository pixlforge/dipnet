<template>
  <div>
    <h2 class="comments__title">Commentaires</h2>
    <app-add-comment :data-business="dataBusiness"
                     :data-avatar-path="dataAvatarPath"
                     :data-random-avatar="dataRandomAvatar"
                     @postedComment="addComment">
    </app-add-comment>
    <transition-group name="highlight">
      <app-comment v-for="(comment, index) in comments"
                   :key="comment.id"
                   :data-comment="comment">
      </app-comment>
    </transition-group>
  </div>
</template>

<script>
  import AddComment from './AddComment'
  import Comment from './Comment'

  export default {
    props: [
      'data-business',
      'data-avatar-path',
      'data-random-avatar',
      'data-comments',
      'data-user'
    ],
    data() {
      return {
        comments: this.dataComments
      }
    },
    components: {
      'app-add-comment': AddComment,
      'app-comment': Comment
    },
    methods: {
      addComment(comment) {
        const newComment = {
          id: comment.id,
          body: comment.body,
          user: this.dataUser
        }
        this.comments.unshift(newComment)
        flash({
          message: "Votre commentaire a bien été posté!",
          level: 'success'
        })
      }
    }
  }
</script>