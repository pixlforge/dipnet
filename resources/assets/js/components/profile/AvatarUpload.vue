<template>
  <div>
    <h2 class="modal__title">Avatar</h2>

    <div class="modal__group">
      <label for="avatar"
             class="btn btn--black">
        <i class="fal fa-folder-open"></i>
        Sélectionner une image
      </label>
      <input type="file"
             name="avatar"
             id="avatar"
             class="v-hidden"
             @change="fileChange">
      <div class="modal__alert"
           v-if="errors.length">
        {{ errors[0] }}
      </div>
    </div>

    <div class="modal__group">
      <img :src="avatar.path"
           class="avatar__img"
           alt="Avatar à modifier"
           v-if="avatar.path">

      <img :src="currentAvatar"
           class="avatar__img"
           alt="Avatar actuel"
           v-if="currentAvatar && !avatar.path">

      <img :src="randomAvatarPath"
           alt="Avatar par défaut"
           v-if="!avatar.path && !currentAvatar"
           style="width: 200px;">
    </div>

    <div class="modal__buttons modal__buttons--avatar" v-if="avatar.path">
      <button class="btn btn--black"
              @click.prevent="update">
        <i class="fal fa-upload"></i>
        Mettre à jour l'avatar
      </button>
    </div>


  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    props: [
      'data-avatar',
      'data-random-avatar'
    ],
    data() {
      return {
        currentAvatar: this.dataAvatar,
        avatar: {
          id: null,
          path: this.currentAvatar
        },
        endpoint: '/profile/avatar',
        errors: {},
        sendAs: 'avatar'
      }
    },
    computed: {
      /**
       * Get a random avatar's path.
       */
      randomAvatarPath() {
        return 'img/placeholders/' + this.dataRandomAvatar
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Upload on file change.
       */
      fileChange(event) {
        this.upload(event)
      },

      /**
       * Upload an avatar.
       */
      upload(event) {
        this.$store.dispatch('toggleLoader')

        axios.post(this.endpoint, this.packageUploads(event))
          .then(response => {
            this.$store.dispatch('toggleLoader')
            this.avatar = response.data
            flash({
              message: "Avatar valide. Vous pouvez sauver cette image en tant qu'avatar personnel.",
              level: 'success'
            })
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            if (error.response.status === 422) {
              this.errors = error.response.data.errors.avatar
              flash({
                message: this.errors[0],
                level: 'danger'
              })
              return
            }
            this.errors = "Une erreur est survenue. Veuillez réessayer plus tard."
          })
      },

      /**
       * Get the file data.
       */
      packageUploads(event) {
        let fileData = new FormData()
        fileData.append(this.sendAs, event.target.files[0])
        return fileData
      },

      /**
       * Update the avatar.
       */
      update() {
        this.$store.dispatch('toggleLoader')

        axios.patch('/profile/avatar', {
          avatar: {
            id: this.avatar.id
          }
        }).then(() => {
          this.$store.dispatch('toggleLoader')
          flash({
            message: "Votre avatar a bien été mis à jour.",
            level: 'success'
          })
          setTimeout(() => {
            window.location = route('profile.index')
          }, 1500)
        }).catch(() => {
          this.$store.dispatch('toggleLoader')
          flash({
            message: "Il y a eu un problème, votre compte n'a pas été mis à jour.",
            level: 'danger'
          })
        })
      }
    }
  }
</script>
