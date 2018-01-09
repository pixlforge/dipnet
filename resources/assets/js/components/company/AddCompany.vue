<template>
  <div>
    <button class="btn btn--black-large"
            @click="toggleModal">
      <i class="fal fa-plus-circle"></i>
      Nouvelle société
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
           @keyup.enter="addCompany">

        <div class="modal__container">
          <h2 class="modal__title">Nouvelle société</h2>

          <!--Name-->
          <div class="modal__group">
            <label for="name" class="modal__label">Nom</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="name"
                   id="name"
                   class="modal__input"
                   v-model.trim="company.name"
                   required autofocus>
            <div class="modal__alert"
                 v-if="errors.name">
              {{ errors.name[0] }}
            </div>
          </div>

          <!--Status-->
          <div class="modal__group">
            <label for="status" class="modal__label">Statut</label>
            <select name="status"
                    id="status"
                    class="modal__select"
                    v-model.trim="company.status">
              <option disabled>Sélectionnez un statut</option>
              <option value="temporaire">Temporaire</option>
              <option value="permanent">Permanent</option>
            </select>
            <div class="modal__alert"
                 v-if="errors.status">
              {{ errors.status[0] }}
            </div>
          </div>

          <!--Description-->
          <div class="modal__group">
            <label for="description" class="modal__label">Description</label>
            <input type="text"
                   name="description"
                   id="description"
                   class="modal__input"
                   v-model.trim="company.description">
            <div class="modal__alert"
                 v-if="errors.description">
              {{ errors.description[0] }}
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
                    @click.prevent="addCompany">
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
    data() {
      return {
        company: {
          name: '',
          status: '',
          description: '',
        },
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Add a company.
       */
      addCompany() {
        this.$store.dispatch('toggleLoader')

        axios.post(route('companies.store'), this.company)
          .then(response => {
            this.company = response.data
            this.$emit('companyWasCreated', this.company)
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.company = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>
