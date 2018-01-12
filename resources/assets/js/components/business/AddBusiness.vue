<template>
  <div>
    <button class="btn btn--black-large"
            @click="toggleModal">
      <i class="fal fa-plus-circle"></i>
      Nouvelle affaire
    </button>

    <transition name="fade">
      <div class="modal__background"
           v-if="showModal"
           @click="toggleModal">$
      </div>
    </transition>

    <transition name="slide">
      <div class="modal__slider"
           v-if="showModal"
           @keyup.esc="toggleModal"
           @keyup.enter="addBusiness">

        <div class="modal__container">
          <h2 class="modal__title">Nouvelle affaire</h2>

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
          <div class="modal__group">
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
                      :value="contact.contact[index].id">
                {{ contact.contact[index].name }}
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
            <button class="btn btn--black"
                    @click.prevent="addBusiness">
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
    data() {
      return {
        business: {
          name: '',
          reference: '',
          description: '',
          company_id: '',
          contact_id: ''
        },
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
          return this.companies.filter(company => {
            return company.id === this.business.company_id
          })
        }
      }
    },
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Add a business.
       */
      addBusiness() {
        this.$store.dispatch('toggleLoader')

        axios.post(route('businesses.store'), this.business)
          .then(response => {
            this.business = response.data
            this.$emit('businessWasCreated', this.business)
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.business = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>
