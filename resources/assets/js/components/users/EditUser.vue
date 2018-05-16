<template>
  <div>
    <div role="button"
         @click="toggleModal">
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

          <div class="modal__group">
            <label for="username" class="modal__label">Nom d'utilisateur</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="username"
                   id="username"
                   class="modal__input"
                   v-model.trim="currentUser.username"
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
                   v-model.trim="currentUser.email"
                   required autofocus>
            <div class="modal__alert"
                 v-if="errors.email">
              {{ errors.email[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="password" class="modal__label">Mot de passe</label>
            <span class="modal__required">*</span>
            <input type="password"
                   name="password"
                   id="password"
                   class="modal__input"
                   v-model.trim="currentUser.password"
                   required>
            <div class="modal__alert"
                 v-if="errors.password">
              {{ errors.password[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="password_confirmation" class="modal__label">Confirmation</label>
            <span class="modal__required">*</span>
            <input type="password"
                   name="password_confirmation"
                   id="password_confirmation"
                   class="modal__input"
                   v-model.trim="currentUser.password_confirmation"
                   required>
            <div class="modal__alert"
                 v-if="errors.password_confirmation">
              {{ errors.password_confirmation[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="role" class="modal__label">Rôle</label>
            <select name="role"
                    id="role"
                    class="modal__select"
                    v-model.trim="currentUser.role">
              <option disabled>Sélectionnez un rôle</option>
              <option value="utilisateur">Utilisateur</option>
              <option value="administrateur">Administrateur</option>
            </select>
            <div class="modal__alert"
                 v-if="errors.role">
              {{ errors.role[0] }}
            </div>
          </div>

          <div class="modal__group"
               v-if="userIsNotAdmin">
            <label for="company_id" class="modal__label">Société</label>
            <select name="company_id"
                    id="company_id"
                    class="modal__select"
                    v-model.trim="currentUser.company_id">
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

          <div class="modal__buttons">
            <button class="btn btn--grey"
                    role="button"
                    @click.stop="toggleModal">
              <i class="fal fa-times"></i>
              Annuler
            </button>
            <button class="btn btn--red"
                    role="button"
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
    props: {
      user: {
        type: Object,
        required: true
      },
      companies: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        currentUser: {
          id: this.user.id,
          username: this.user.username,
          email: this.user.email,
          password: null,
          password_confirmation: null,
          role: this.user.role,
          company_id: this.user.company_id
        },
        errors: {}
      }
    },
    computed: {
      userIsNotAdmin() {
        return this.currentUser.role === '' || this.currentUser.role === 'utilisateur'
      }
    },
    mixins: [mixins],
    methods: {
      updateUser() {
        this.$store.dispatch('toggleLoader')
        axios.put(route('users.update', [this.currentUser.id]), this.currentUser).then(() => {
          eventBus.$emit('userWasUpdated', this.currentUser)
        }).then(() => {
          this.$store.dispatch('toggleLoader')
          this.toggleModal()
          this.currentUser.password = null
          this.currentUser.password_confirmation = null
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
          this.currentUser.password = null
          this.currentUser.password_confirmation = null
        })
      }
    }
  }
</script>
