<template>
  <div>
    <h2 class="modal__title">Avatar</h2>

    <div class="modal__group">
      <label for="avatar"
             class="btn btn--red">
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
      <img :src="newAvatar.path"
           class="avatar__img"
           alt="Avatar à modifier"
           v-if="newAvatar.path">

      <img :src="avatar"
           class="avatar__img"
           alt="Avatar actuel"
           v-if="avatar && !newAvatar.path">

      <img :src="randomAvatarPath"
           alt="Avatar par défaut"
           v-if="!newAvatar.path && !avatar"
           style="width: 200px;">
    </div>

    <div class="modal__buttons modal__buttons--avatar"
         v-if="newAvatar.id">
      <button class="btn btn--red"
              role="button"
              @click.prevent="update">
        <i class="fal fa-upload"></i>
        Mettre à jour l'avatar
      </button>
    </div>
  </div>
</template>

<script>
  import mixins from '../../mixins'

  export default {
    props: {
      avatar: {
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
        newAvatar: {
          id: null,
          path: this.avatar
        },
        endpoint: '/profile/avatar',
        errors: {},
        sendAs: 'avatar'
      }
    },
    computed: {
      randomAvatarPath() {
        return 'img/placeholders/' + this.randomAvatar
      }
    },
    mixins: [mixins],
    methods: {
      fileChange(event) {
        this.upload(event)
      },
      upload(event) {
        this.$store.dispatch('toggleLoader')
        axios.post(this.endpoint, this.packageUploads(event)).then(response => {
          this.$store.dispatch('toggleLoader')
          this.newAvatar = response.data
          flash({
            message: "Avatar valide. Vous pouvez sauver cette image en tant qu'avatar personnel.",
            level: 'success'
          })
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
        })
      },
      packageUploads(event) {
        const fileData = new FormData()
        fileData.append(this.sendAs, event.target.files[0])
        return fileData
      },
      update() {
        this.$store.dispatch('toggleLoader')
        axios.patch('/profile/avatar', {
          avatar: {
            id: this.newAvatar.id
          }
        }).then(() => {
          this.$store.dispatch('toggleLoader')
          flash({
            message: "Votre avatar a bien été mis à jour.",
            level: 'success'
          })
          setTimeout(() => {
            window.location = route('profile.index')
          }, 500)
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
