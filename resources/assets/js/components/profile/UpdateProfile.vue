<template>
  <div>
    <button class="btn btn--red"
            role="button"
            @click="toggleModal">
      <i class="fal fa-pencil"></i>
      Éditer mon compte
    </button>

    <transition name="fade">
      <div class="modal__background"
           v-if="showModal"
           @click="toggleModal">
      </div>
    </transition>

    <transition name="slide">
      <div class="modal__slider"
           v-if="showModal"
           @keyup.esc="toggleModal"
           @keyup.enter="updateProfile">

        <div class="modal__container">

          <avatar-upload :avatar="avatar"
                         :random-avatar="randomAvatar"></avatar-upload>

          <h2 class="modal__title">Mise à jour des informations du compte</h2>

          <div class="modal__group">
            <label for="username" class="modal__label">Nom</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="username"
                   id="username"
                   class="modal__input"
                   v-model.trim="user.username"
                   required autofocus>
            <div class="modal__alert"
                 v-if="errors.username">
              {{ errors.username[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="email" class="modal__label">Email</label>
            <span class="modal__required">*</span>
            <input type="email"
                   name="email"
                   id="email"
                   class="modal__input"
                   v-model.trim="user.email"
                   required>
            <div class="modal__alert"
                 v-if="errors.email">
              {{ errors.email[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="password" class="modal__label">Password</label>
            <span class="modal__required">*</span>
            <input type="password"
                   name="password"
                   id="password"
                   class="modal__input"
                   v-model.trim="user.password"
                   required>
            <div class="modal__alert"
                 v-if="errors.password">
              {{ errors.password[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="password_confirmation" class="modal__label">Confirmation du mot de passe</label>
            <span class="modal__required">*</span>
            <input type="password"
                   name="password_confirmation"
                   id="password_confirmation"
                   class="modal__input"
                   v-model.trim="user.password_confirmation"
                   required>
            <div class="modal__alert"
                 v-if="errors.password_confirmation">
              {{ errors.password_confirmation[0] }}
            </div>
          </div>

          <div class="modal__buttons">
            <button class="btn btn--grey"
                    role="button"
                    @click.stop="toggleModal">
              <i class="fal fa-times"></i>
              Annuler
            </button>
            <button class="btn btn--red"
                    role="button"
                    @click.prevent="updateProfile">
              <i class="fal fa-check"></i>
              Mettre à jour
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
  import AvatarUpload from './AvatarUpload.vue'
  import mixins from '../../mixins'

  export default {
    components: {
      AvatarUpload
    },
    props: {
      user: {
        type: Object,
        required: true
      },
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
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      updateProfile() {
        this.$store.dispatch('toggleLoader')
        axios.patch(route('account.update'), this.user).then(() => {
          this.$store.dispatch('toggleLoader')
          this.toggleModal()
          this.errors = {}
          this.user.password = ''
          this.user.password_confirmation = ''
          flash({
            message: "Votre compte a été mis à jour avec succès!",
            level: 'success'
          })
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
          this.errors = error.response.data.errors
        })
      }
    },
    mounted() {
      this.user.password = null
    }
  }
</script>
