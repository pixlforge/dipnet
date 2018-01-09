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
           @keyup.enter="editCompany">

        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ company.name }}</h2>

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
    props: ['data-company'],
    data() {
      return {
        company: this.dataCompany,
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Update a company.
       */
      updateCompany() {
        this.$store.dispatch('toggleLoader')

        axios.put(route('companies.update', [this.company.id]), this.company)
          .then(() => {
            eventBus.$emit('companyWasUpdated', this.company)
          })
          .then(() => {
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
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
    },
    created() {
      eventBus.$on('openEditCompany', () => {
        this.toggleModal()
      })
    }
  }
</script>
