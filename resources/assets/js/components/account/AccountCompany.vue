<template>
  <div class="register__container"
       @keyup.enter="createCompany">
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

        <div class="register__summary-item register__summary-item--done">
          <span class="badge__summary">2</span>
          <span class="register__summary-label">Création de votre premier contact</span>
        </div>

        <div class="register__summary-item register__summary-item--active">
          <span class="badge__summary">3</span>
          <span class="register__summary-label">Création de votre société</span>
        </div>

        <div class="register__summary-item">
          <span class="badge__summary">4</span>
          <span class="register__summary-label">Terminé!</span>
        </div>
      </div>
    </section>

    <section class="register__form-section">
      <div class="register__form">
        <h1 class="register__title">Votre société</h1>

        <div class="form__group">
          <label for="name">Nom de la société</label>
          <span class="form__required">*</span>
          <input type="text"
                 name="name"
                 id="name"
                 class="form__input"
                 v-model.trim="company.name"
                 required autofocus>
          <div class="form__alert"
               v-if="errors.name">
            {{ errors.name[0] }}
          </div>
        </div>

        <div class="register__buttons">
          <button class="btn btn--red"
                  @click="createCompany">
            <i class="fal fa-check"></i>
            Terminer l'enregistrement
          </button>
        </div>
      </div>
    </section>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      MoonLoader,
    },
    props: {
      dataAppName: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        company: {
          name: ''
        },
        errors: {}
      }
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Create a new company.
       */
      createCompany() {
        this.$store.dispatch('toggleLoader')
        axios.post(route('register.company.store'), this.company).then(() => {
          this.company = {}
          flash({
            message: 'Félicitations! Votre compte a bien été mis à jour!',
            level: 'success'
          })
          setTimeout(() => {
            window.location = route('index')
          }, 1000)
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
          this.errors = error.response.data.errors
        })
      }
    }
  }
</script>
