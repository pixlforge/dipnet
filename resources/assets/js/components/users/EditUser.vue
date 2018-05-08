<template>
  <div>
    <div @click="toggleModal">
      <i class="fal fa-pencil"></i>
    </div>

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
           @keyup.enter="updateUser">

        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ user.username}}</h2>

          <!--Username-->
          <div class="modal__group">
            <label for="username" class="modal__label">Nom d'utilisateur</label>
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
                   required autofocus>
            <div class="modal__alert"
                 v-if="errors.email">
              {{ errors.email[0] }}
            </div>
          </div>

          <!--Password-->
          <div class="modal__group">
            <label for="password" class="modal__label">Mot de passe</label>
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

          <!--Password Confirmation-->
          <div class="modal__group">
            <label for="password_confirmation" class="modal__label">Confirmation</label>
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

          <!--Role-->
          <div class="modal__group">
            <label for="role" class="modal__label">Rôle</label>
            <select name="role"
                    id="role"
                    class="modal__select"
                    v-model.trim="user.role">
              <option disabled>Sélectionnez un rôle</option>
              <option value="utilisateur">Utilisateur</option>
              <option value="administrateur">Administrateur</option>
            </select>
            <div class="modal__alert"
                 v-if="errors.role">
              {{ errors.role[0] }}
            </div>
          </div>

          <!--Company-->
          <div class="modal__group"
               v-if="userIsNotAdmin">
            <label for="company_id" class="modal__label">Société</label>
            <select name="company_id"
                    id="company_id"
                    class="modal__select"
                    v-model.trim="user.company_id">
              <option disabled>Sélectionnez une société</option>
              <option v-for="(company, index) in companies"
                      :value="company.id">
                {{ company.name }}
              </option>
            </select>
            <div class="modal__alert"
                 v-if="errors.company_id">
              {{ errors.company_id[0] }}
            </div>
          </div>

          <!--Buttons-->
          <div class="modal__buttons">
            <button class="btn btn--grey"
                    @click.stop="toggleModal">
              <i class="fal fa-times"></i>
              Annuler
            </button>
            <button class="btn btn--red"
                    @click.prevent="updateUser">
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
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapActions } from 'vuex'

  export default {
    computed: {
      userIsNotAdmin() {
        return this.user.role === '' || this.user.role === 'utilisateur'
      }
    },
    props: {
      dataUser: {
        type: Object,
        required: true
      },
      dataCompanies: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        user: {
          id: this.dataUser.id,
          username: this.dataUser.username,
          email: this.dataUser.email,
          password: null,
          password_confirmation: null,
          role: this.dataUser.role,
          company_id: this.dataUser.company_id
        },
        companies: this.dataCompanies,
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Update the user.
       */
      updateUser() {
        this.$store.dispatch('toggleLoader')

        axios.put(route('users.update', [this.user.id]), this.user)
          .then(() => {
            eventBus.$emit('userWasUpdated', this.user)
          })
          .then(() => {
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.user.password = null
            this.user.password_confirmation = null
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.user.password = null
            this.user.password_confirmation = null
            if (error.response.status === 422) {
              flash({
                message: "Erreur. La validation a échoué.",
                level: 'danger'
              })
              return
            }
            flash({
              message: "Erreur. Veuillez réessayer plus tard.",
              level: 'danger'
            })
          })
      }
    }
  }
</script>
