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
           @keyup.enter="updateContact">

        <div class="modal__container">
          <h2 class="modal__title">Nouveau contact</h2>

          <!--Name-->
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

          <!--Address line 1-->
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

          <!--Address line 2-->
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

          <!--Zip-->
          <div class="modal__group">
            <label for="zip" class="modal__label">NPA</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="zip"
                   id="zip"
                   class="modal__input"
                   v-model.trim="contact.zip"
                   required>
            <div class="modal__alert"
                 v-if="errors.zip">
              {{ errors.zip[0] }}
            </div>
          </div>

          <!--City-->
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

          <!--Phone-->
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

          <!--Fax-->
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

          <!--Email-->
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

          <!--Buttons-->
          <div class="modal__buttons">
            <button class="btn btn--grey"
                    @click.stop="toggleModal">
              <i class="fal fa-times"></i>
              Annuler
            </button>
            <button class="btn btn--black"
                    @click.prevent="updateContact">
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
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapActions } from 'vuex'

  export default {
    props: ['data-contact'],
    data() {
      return {
        contact: this.dataContact,
        errors: {}
      }
    },
    components: {
      'app-moon-loader': MoonLoader
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Update a contact.
       */
      updateContact() {
        this.$store.dispatch('toggleLoader')

        axios.put(route('contacts.update', [this.contact.id]), this.contact)
          .then(() => {
            eventBus.$emit('contactWasUpdated', this.contact)
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
