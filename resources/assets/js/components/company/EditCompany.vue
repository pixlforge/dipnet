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
           @keyup.enter="updateCompany">
        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ company.name }}</h2>

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

          <div class="modal__buttons">
            <button class="btn btn--grey"
                    role="button"
                    @click.stop="toggleModal">
              <i class="fal fa-times"></i>
              Annuler
            </button>
            <button class="btn btn--red"
                    role="button"
                    @click.prevent="updateCompany">
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
      company: {
        type: Object,
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
      ...mapActions([
        'toggleLoader'
      ]),
      updateCompany() {
        this.$store.dispatch('toggleLoader')
        axios.put(route('companies.update', [this.company.id]), this.company).then(() => {
            eventBus.$emit('companyWasUpdated', this.company)
          }).then(() => {
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
          }).catch(() => {
            this.$store.dispatch('toggleLoader')
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
