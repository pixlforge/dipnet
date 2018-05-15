<template>
  <div title="Modifier"
       role="button">
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

          <div class="modal__group"
               v-if="user.role === 'administrateur'">
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

          <div class="modal__group"
               v-if="user.role === 'administrateur'">
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

          <div class="modal__group">
            <label for="contact_id" class="modal__label">Contact</label>
            <select name="contact_id"
                    id="contact_id"
                    class="modal__select"
                    v-model.number.trim="business.contact_id">
              <option disabled>Sélectionnez un contact</option>
              <option v-for="(contact, index) in filteredContacts"
                      :value="contact.id">
                {{ contact.name }}
              </option>
            </select>
            <div class="modal__alert"
                 v-if="errors.contact_id">
              {{ errors.contact_id[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="folder_color" class="modal__label">Couleur</label>
            <select name="folder_color"
                    id="folder_color"
                    class="modal__select"
                    v-model="business.folder_color">
              <option disabled>Sélectionner une couleur</option>
              <option value="red">Rouge</option>
              <option value="orange">Orange</option>
              <option value="purple">Violet</option>
              <option value="blue">Bleu</option>
            </select>
            <div class="modal__alert"
                 v-if="errors.folder_color">
              {{ errors.folder_color[0] }}
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
    props: {
      business: {
        type: Object,
        required: true
      },
      companies: {
        type: Array,
        required: false
      },
      contacts: {
        type: Array,
        required: true
      },
      user: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        errors: {}
      }
    },
    computed: {
      filteredContacts() {
        if (this.business.company_id !== '') {
          return this.contacts.filter(contact => {
            return contact.company_id === this.business.company_id
          })
        }
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),
      updateBusiness() {
        this.$store.dispatch('toggleLoader')
        axios.put(route('businesses.update', [this.business.id]), this.business).then(() => {
          eventBus.$emit('businessWasUpdated', this.business)
        }).then(() => {
          this.$store.dispatch('toggleLoader')
          this.toggleModal()
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
          this.errors = error.response.data
        })
      }
    }
  }
</script>
