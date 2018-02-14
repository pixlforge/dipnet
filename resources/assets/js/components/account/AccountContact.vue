<template>
  <div class="register__container"
       @keyup.enter="createContact">
    <section class="register__summary-section">
      <div class="register__logo register__logo--summary"
           aria-hidden="true">
        <img :src="logoBw" :alt="`${appName} logo`">
      </div>
      <div class="register__summary">
        <div class="register__summary-item register__summary-item--done">
          <span class="badge__summary"><i class="fa fa-check"></i></span>
          <span class="register__summary-label">Création de votre compte</span>
        </div>

        <div class="register__summary-item register__summary-item--active">
          <span class="badge__summary">2</span>
          <span class="register__summary-label">Création de votre premier contact</span>
        </div>

        <div class="register__summary-item"
             v-if="!dataUser.company_confirmed">
          <span class="badge__summary">3</span>
          <span class="register__summary-label">Création de votre société</span>
        </div>

        <div class="register__summary-item">
          <span class="badge__summary" v-if="!dataUser.company_confirmed">4</span>
          <span class="badge__summary" v-else>3</span>
          <span class="register__summary-label">Terminé!</span>
        </div>
      </div>
    </section>

    <section class="register__form-section">
      <div class="register__form">
        <h1 class="register__title">Votre premier contact</h1>

        <div class="form__group">
          <label for="name">Prénom et Nom / Contact</label>
          <span class="form__required">*</span>
          <input type="text"
                 name="name"
                 id="name"
                 class="form__input"
                 v-model.trim="contact.name"
                 required autofocus>
          <div class="form__alert"
               v-if="errors.name">
            {{ errors.name[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="address_line1">Adresse ligne 1</label>
          <span class="form__required">*</span>
          <input type="text"
                 name="address_line1"
                 id="address_line1"
                 class="form__input"
                 v-model.trim="contact.address_line1"
                 required>
          <div class="form__alert"
               v-if="errors.address_line1">
            {{ errors.address_line1[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="address_line2">Adresse ligne 2</label>
          <input type="text"
                 name="address_line2"
                 id="address_line2"
                 class="form__input"
                 v-model.trim="contact.address_line2">
          <div class="form__alert"
               v-if="errors.address_line2">
            {{ errors.address_line2[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="zip">NPA</label>
          <span class="form__required">*</span>
          <input type="text"
                 name="zip"
                 id="zip"
                 class="form__input"
                 v-model.trim="contact.zip"
                 required>
          <div class="form__alert"
               v-if="errors.zip">
            {{ errors.zip[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="city">Localité</label>
          <span class="form__required">*</span>
          <input type="text"
                 name="city"
                 id="city"
                 class="form__input"
                 v-model.trim="contact.city"
                 required>
          <div class="form__alert"
               v-if="errors.city">
            {{ errors.city[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="phone_number">Téléphone</label>
          <input type="text"
                 name="phone_number"
                 id="phone_number"
                 class="form__input"
                 v-model.trim="contact.phone_number">
          <div class="form__alert"
               v-if="errors.phone_number">
            {{ errors.phone_number[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="fax">Fax</label>
          <input type="text"
                 name="fax"
                 id="fax"
                 class="form__input"
                 v-model.trim="contact.fax">
          <div class="form__alert"
               v-if="errors.fax">
            {{ errors.fax[0] }}
          </div>
        </div>

        <div class="register__buttons">
          <button class="btn btn--red"
                  @click="createContact">
            <i class="fal fa-check"></i>
            Créer le contact
          </button>
        </div>
      </div>
    </section>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    props: [
      'data-app-name',
      'data-user'
    ],
    data() {
      return {
        contact: {
          name: '',
          address_line1: '',
          address_line2: '',
          zip: '',
          city: '',
          phone_number: '',
          fax: ''
        },
        errors: {}
      }
    },
    components: {
      'app-moon-loader': MoonLoader,
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Create the contact.
       */
      createContact() {
        this.$store.dispatch('toggleLoader')

        axios.post(route('register.contact.store'), this.contact)
          .then(() => {
            this.contact = {}
            flash({
              message: 'Félicitations! Votre compte a bien été mis à jour!',
              level: 'success'
            })
            setTimeout(() => {
              window.location = route('index')
            }, 1000)
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>
