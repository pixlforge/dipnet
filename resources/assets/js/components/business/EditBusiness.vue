<template>
  <div>
    <div @click="toggleModal">
      <slot>
        <div>
          <i class="fal fa-pencil"></i>
        </div>
      </slot>
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
           @keyup.enter="updateBusiness">

        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ business.name }}</h2>

          <!--Name-->
          <div class="modal__group">
            <label for="name" class="modal__label">Nom</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="name"
                   id="name"
                   class="modal__input"
                   v-model.trim="business.name"
                   required autofocus>
            <div class="modal__alert"
                 v-if="errors.name">
              {{ errors.name[0] }}
            </div>
          </div>

          <!--Reference-->
          <div class="modal__group">
            <label for="reference" class="modal__label">Référence</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="reference"
                   id="reference"
                   class="modal__input"
                   v-model.trim="business.reference"
                   required>
            <div class="modal__alert"
                 v-if="errors.reference">
              {{ errors.reference[0] }}
            </div>
          </div>

          <!--Description-->
          <div class="modal__group">
            <label for="description" class="modal__label">Description</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="description"
                   id="description"
                   class="modal__input"
                   v-model.trim="business.description"
                   required>
            <div class="modal__alert"
                 v-if="errors.description">
              {{ errors.description[0] }}
            </div>
          </div>

          <!--Company-->
          <div class="modal__group" v-if="dataUser.role === 'administrateur'">
            <label for="company_id" class="modal__label">Société</label>
            <select name="company_id"
                    id="company_id"
                    class="modal__select"
                    v-model.number.trim="business.company_id">
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

          <!--Contact-->
          <div class="modal__group">
            <label for="contact_id" class="modal__label">Contact</label>
            <select name="contact_id"
                    id="contact_id"
                    class="modal__select"
                    v-model.number.trim="business.contact_id">
              <option disabled>Sélectionnez un contact</option>
              <option v-for="(contact, index) in contacts"
                      :value="contact.id">
                {{ contact.name }}
              </option>
            </select>
            <div class="modal__alert"
                 v-if="errors.contact_id">
              {{ errors.contact_id[0] }}
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
                    @click.prevent="updateBusiness">
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
    props: [
      'data-business',
      'data-companies',
      'data-contacts',
      'data-user'
    ],
    data() {
      return {
        business: this.dataBusiness,
        companies: this.dataCompanies,
        errors: {}
      }
    },
    mixins: [mixins],
    computed: {
      /**
       * Get the contacts associated with the company.
       */
      contacts() {
        if (this.business.company_id !== '') {
          return this.dataContacts.filter(contact => {
            return contact.company_id === this.business.company_id
          })
        }
      }
    },
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Update a business.
       */
      updateBusiness() {
        this.$store.dispatch('toggleLoader')

        axios.put(route('businesses.update', [this.business.id]), this.business)
          .then(() => {
            eventBus.$emit('businessWasUpdated', this.business)
          })
          .then(() => {
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data
          })
      }
    }
  }
</script>
