<template>
  <div>
    <button class="btn btn--red-large"
            role="button"
            @click="toggleModal">
      <i class="fal fa-plus-circle"></i>
      Nouveau contact
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
           @keyup.enter="addContact">

        <div class="modal__container">
          <h2 class="modal__title">Nouveau contact</h2>

          <div class="modal__group">
            <label for="name" class="modal__label">Nom</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="name"
                   id="name"
                   class="modal__input"
                   v-model.trim="contact.name"
                   required autofocus>
            <div class="modal__alert"
                 v-if="errors.name">
              {{ errors.name[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="address_line1" class="modal__label">Adresse ligne 1</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="address_line1"
                   id="address_line1"
                   class="modal__input"
                   v-model.trim="contact.address_line1"
                   required>
            <div class="modal__alert"
                 v-if="errors.address_line1">
              {{ errors.address_line1[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="address_line2" class="modal__label">Adresse ligne 2</label>
            <input type="text"
                   name="address_line2"
                   id="address_line2"
                   class="modal__input"
                   v-model.trim="contact.address_line2">
            <div class="modal__alert"
                 v-if="errors.address_line2">
              {{ errors.address_line2[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="zip" class="modal__label">NPA</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="zip"
                   id="zip"
                   class="modal__input"
                   v-model="contact.zip"
                   required>
            <div class="modal__alert"
                 v-if="errors.zip">
              {{ errors.zip[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="city" class="modal__label">Localité</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="city"
                   id="city"
                   class="modal__input"
                   v-model.trim="contact.city"
                   required>
            <div class="modal__alert"
                 v-if="errors.city">
              {{ errors.city[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="phone_number" class="modal__label">Téléphone</label>
            <input type="text"
                   name="phone_number"
                   id="phone_number"
                   class="modal__input"
                   v-model.trim="contact.phone_number">
            <div class="modal__alert"
                 v-if="errors.phone_number">
              {{ errors.phone_number[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="fax" class="modal__label">Fax</label>
            <input type="text"
                   name="fax"
                   id="fax"
                   class="modal__input"
                   v-model.trim="contact.fax">
            <div class="modal__alert"
                 v-if="errors.fax">
              {{ errors.fax[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label for="email" class="modal__label">Email</label>
            <span class="modal__required">*</span>
            <input type="email"
                   name="email"
                   id="email"
                   class="modal__input"
                   v-model.trim="contact.email"
                   required>
            <div class="modal__alert"
                 v-if="errors.email">
              {{ errors.email[0] }}
            </div>
          </div>

          <div class="modal__group"
               v-if="userIsAdmin">
            <label for="company_id" class="modal__label">Société</label>
            <select name="company_id"
                    id="company_id"
                    class="modal__select"
                    v-model.number.trim="contact.company_id">
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
                    @click.prevent="addContact">
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
  import { eventBus } from '../../app'
  import { mapActions } from 'vuex'

  export default {
    props: {
      companies: {
        type: Array,
        required: false
      },
      user: {
        type: Object,
        required: false
      }
    },
    data() {
      return {
        contact: {
          name: '',
          address_line1: '',
          address_line2: '',
          zip: '',
          city: '',
          phone_number: '',
          fax: '',
          email: '',
          company_id: null
        },
        errors: {}
      }
    },
    computed: {
      userIsAdmin() {
        return this.user.role === 'administrateur'
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),
      addContact() {
        this.$store.dispatch('toggleLoader')
        axios.post(route('contacts.store'), this.contact).then(response => {
            this.contact = response.data
            this.$emit('contactWasCreated', this.contact)
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.contact = {}
          }).catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
            this.redirectIfNotConfirmed(error)
          })
      }
    },
    created() {
      eventBus.$on('dropdownAddContact', () => this.toggleModal())
    }
  }
</script>
