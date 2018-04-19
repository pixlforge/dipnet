<template>
  <div>
    <button class="btn btn--red-large"
            @click="toggleModal">
      <i class="fal fa-plus-circle"></i>
      Nouvel utilisateur
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
           @keyup.enter="addUser">

        <div class="modal__container">
          <h2 class="modal__title">Nouvel utilisateur</h2>

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
            <label for="email" class="modal__label">Adresse Email</label>
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
            <span class="modal__required">*</span>
            <select name="role" id="role" class="modal__select" v-model.trim="user.role">
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
                    v-model.number.trim="user.company_id">
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
                    @click.prevent="addUser">
              <i class="fal fa-check"></i>
              Ajouter
            </button>
          </div>

        </div>
      </div>
    </transition>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    props: ['data-companies'],
    computed: {
      userIsNotAdmin() {
        return this.user.role === '' || this.user.role === 'utilisateur'
      }
    },
    data() {
      return {
        user: {
          username: '',
          password: '',
          role: '',
          email: '',
          company_id: ''
        },
        companies: this.dataCompanies,
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      /**
       * Add a new user.
       */
      addUser() {
        if (this.user.role === 'administrateur') {
          this.user.company_id = null
        }

        this.$store.dispatch('toggleLoader')

        axios.post(route('users.store'), this.user)
          .then(response => {
            this.user = response.data
            this.$emit('userWasCreated', this.user)
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.user = {}
            this.errors = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>