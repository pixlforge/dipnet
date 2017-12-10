<template>
  <div>
    <h3 class="mt-7 mb-5">Avatar</h3>

    <div class="form-group my-5">
      <label for="avatar"
             class="btn btn-lg btn-black">
        <i class="fal fa-folder-open mr-2"></i>
        Sélectionner une image
      </label>
      <input type="file"
             name="avatar"
             id="avatar"
             @change="fileChange">
      <div class="help-block"
           v-if="errors.length"
           v-text="errors[0]">
      </div>
    </div>

    <div class="form-group my-5">
      <img :src="avatar.path"
           class="avatar-upload"
           alt="Avatar à modifier"
           v-if="avatar.path">

      <img :src="currentAvatar"
           class="avatar-upload"
           alt="Avatar actuel"
           v-if="currentAvatar && !avatar.path">

      <img :src="randomAvatarPath"
           alt="Avatar par défaut"
           v-if="!avatar.path && !currentAvatar"
           style="width: 200px;">
    </div>

    <div class="form-group my-5" v-if="avatar.path">
      <button class="btn btn-lg btn-black" @click="update">
        <i class="fal fa-upload mr-2"></i>
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
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Get a random avatar's path.
       */
      randomAvatarPath() {
        return 'img/placeholders/' + this.dataRandomAvatar
      }
    },
    mixins: [mixins],
    methods: {

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
          .then((response) => {
            this.$store.dispatch('toggleLoader')
            this.avatar = response.data
            flash({
              message: "Avatar valide. Vous pouvez sauver cette image en tant qu'avatar personnel.",
              level: 'success'
            })
          })
          .catch((error) => {
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
        })
          .then(() => {
            this.$store.dispatch('toggleLoader')
            flash({
              message: "Votre avatar a bien été mis à jour.",
              level: 'success'
            })
            setTimeout(function () {
              window.location.pathname = '/profile';
            }, 2500)
          })
          .catch(() => {
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

<style scoped>
  label {
    font-size: .875rem !important;
  }

  input {
    display: none;
  }
</style>
