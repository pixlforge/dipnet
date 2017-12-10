<template>
  <div>

    <!--Button-->
    <a class="btn btn-lg btn-black mt-4"
       @click="toggleModal">
      <i class="fal fa-cog mr-2"></i>
      Mettre à jour le compte
    </a>

    <!--Background-->
    <transition name="fade">
      <div class="modal-background"
           v-if="showModal"
           @click="toggleModal">
      </div>
    </transition>

    <!--Modal Panel-->
    <transition name="slide">
      <div class="modal-panel"
           v-if="showModal"
           @keyup.esc="toggleModal"
           @keyup.enter="addContact">
        <div class="container-fluid">
          <div class="row">
            <div class="col-10 col-lg-8 offset-lg-1">

              <app-avatar-upload :data-avatar="avatar"
                                 :data-random-avatar="dataRandomAvatar">
              </app-avatar-upload>

              <!--Title-->
              <h3 class="mt-7 mb-5">Informations de votre compte</h3>

              <!--Form-->
              <form @submit.prevent>

                <!--Username-->
                <div class="form-group">
                  <label for="username">Nom d'utilisateur</label>
                  <span class="required">*</span>
                  <input type="text"
                         id="username"
                         name="username"
                         class="form-control"
                         v-model.trim="user.username"
                         required>
                  <div class="help-block"
                       v-if="errors.username"
                       v-text="errors.username[0]">
                  </div>
                </div>

                <!--Email-->
                <div class="form-group my-5">
                  <label for="email">E-mail</label>
                  <span class="required">*</span>
                  <input type="text"
                         id="email"
                         name="email"
                         class="form-control"
                         v-model.trim="user.email"
                         required>
                  <div class="help-block"
                       v-if="errors.email"
                       v-text="errors.email[0]">
                  </div>
                </div>

                <!--Password-->
                <div class="form-group my-5">
                  <label for="password">Mot de passe</label>
                  <input type="password"
                         name="password"
                         id="password"
                         class="form-control"
                         v-model.trim="user.password">
                  <div class="help-block"
                       v-if="errors.password"
                       v-text="errors.password[0]">
                  </div>
                </div>

                <!--Password Confirmation-->
                <div class="form-group my-5">
                  <label for="password_confirmation">Confirmation du mot de passe</label>
                  <input type="password"
                         name="password_confirmation"
                         id="password_confirmation"
                         class="form-control"
                         v-model.trim="user.password_confirmation">
                  <div class="help-block"
                       v-if="errors.password_confirmation"
                       v-text="errors.password_confirmation[0]">
                  </div>
                </div>

                <!--Buttons-->
                <div class="form-group d-flex flex-column flex-lg-row my-6">
                  <div class="col-12 col-lg-5 px-0 pr-lg-2">
                    <button class="btn btn-block btn-lg btn-white"
                            @click.stop="toggleModal">
                      <i class="fal fa-times mr-2"></i>
                      Annuler
                    </button>
                  </div>
                  <div class="col-12 col-lg-7 px-0 pl-lg-2">
                    <button class="btn btn-block btn-lg btn-black"
                            @click.prevent="updateProfile">
                      <i class="fal fa-check mr-2"></i>
                      Sauvegarder
                    </button>
                  </div>
                </div>
              </form>
            </div>
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

        axios.patch('/account/update', this.user)
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
