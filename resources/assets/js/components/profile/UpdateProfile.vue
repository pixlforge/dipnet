<template>
  <div>
    <button class="btn btn--black"
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
           @keyup.enter="updateArticle">

        <div class="modal__container">

          <app-avatar-upload :data-avatar="avatar"
                             :data-random-avatar="dataRandomAvatar">
          </app-avatar-upload>

          <h2 class="modal__title">Mise à jour des informations du compte</h2>

          <!--Name-->
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

          <!--Email-->
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

          <!--Password-->
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

          <!--Password-->
          <div class="modal__group">
            <label for="password_confirmation" class="modal__label">Confirmation du mot de passer</label>
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

          <!--Buttons-->
          <div class="modal__buttons">
            <button class="btn btn--grey"
                    @click.stop="toggleModal">
              <i class="fal fa-times"></i>
              Annuler
            </button>
            <button class="btn btn--black"
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
  import { mapActions } from 'vuex'

  export default {
    props: [
      'data-user',
      'data-avatar',
      'data-random-avatar'
    ],
    data() {
      return {
        avatar: this.dataAvatar,
        user: {
          username: this.dataUser.username,
          email: this.dataUser.email,
          password: '',
          password_confirmation: ''
        },
        errors: {}
      }
    },
    mixins: [mixins],
    components: {
      'app-avatar-upload': AvatarUpload
    },
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Update the user's profile.
       */
      updateProfile() {
        this.$store.dispatch('toggleLoader')

        axios.patch(route('account.update'), this.user)
          .then(response => {
            this.toggleModal()
            this.$store.dispatch('toggleLoader')
            this.errors = {}
            this.user.password = ''
            this.user.password_confirmation = ''
            flash({
              message: "Votre compte a été mis à jour avec succès!",
              level: 'success'
            })
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
            if (error.response.status === 422) {
              flash({
                message: "La mise à jour de votre compte a échoué, veuillez vérifiez qu'il n'existe aucune erreur.",
                level: 'danger'
              })
              return
            }
            flash({
              message: "La mise à jour de votre compte a échoué, veuillez réessayer plus tard.",
              level: 'danger'
            })
          })
      }
    }
  }
</script>
