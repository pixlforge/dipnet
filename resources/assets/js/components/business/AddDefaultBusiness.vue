<template>
  <div class="alert-page__container">
    <transition name="fade" mode="out-in" appear>
      <div class="alert-page__card"
           key="start"
           v-if="showAlert">
        <img src="/img/icons/alert@3x.png" class="alert-page__icon" alt="Attention">
        <h1 class="alert-page__title">Définir une affaire</h1>
        <p class="alert-page__paragraph">
          {{ context }} disposer d'une affaire par défaut. Cliquez sur le bouton pour en ajouter une.
        </p>
        <button class="btn btn--red"
                role="button"
                @click="toggleAlert">
          <i class="fal fa-plus-circle"></i>
          Ajouter
        </button>
      </div>
      <div class="alert-page__card--large" key="end" v-else>
        <h1 class="alert-page__title">Ajouter une affaire</h1>
        <form class="alert-page__form">

          <div class="form__group">
            <label class="form__label" for="name">Nom</label>
            <span class="form__required">*</span>
            <input type="text"
                   id="name"
                   name="name"
                   class="form__input"
                   v-model.trim="business.name"
                   required autofocus>
            <div class="form__alert"
                 v-if="errors.name"
                 v-text="errors.name[0]">
            </div>
          </div>

          <div class="form__group">
            <label class="form__label" for="description">Description</label>
            <input type="text"
                   id="description"
                   name="description"
                   class="form__input"
                   v-model.trim="business.description">
            <div class="form__alert"
                 v-if="errors.description"
                 v-text="errors.description[0]">
            </div>
          </div>

          <div class="form__group">
            <label class="form__label" for="contact_id">Contact</label>
            <span class="form__required">*</span>
            <select name="contact_id"
                    id="contact_id"
                    class="form__select"
                    v-model.number.trim="business.contact_id">
              <option disabled>Sélectionnez un contact</option>
              <option v-for="(contact, index) in contacts"
                      :value="contact.id"
                      v-text="contact.name">
              </option>
            </select>
            <div class="form__alert"
                 v-if="errors.contact_id"
                 v-text="errors.contact_id[0]">
            </div>
          </div>
        </form>
        <button class="btn btn--red"
                role="button"
                @click="addBusiness">
          <i class="fal fa-check"></i>
          Terminer
        </button>
      </div>
    </transition>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    components: {
      MoonLoader
    },
    props: {
      company: {
        type: Object,
        required: true
      },
      contacts: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        showAlert: true,
        business: {
          name: '',
          description: '',
          contact_id: '',
          company_id: this.company.id,
          setDefault: true
        },
        errors: {}
      }
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ]),
      context() {
        if (this.company.name === 'Particulier') {
          return "Vous devez"
        } else {
          return "Votre société doit"
        }
      }
    },
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),
      addBusiness() {
        this.$store.dispatch('toggleLoader')
        axios.post(route('businesses.store'), this.business).then(() => {
          flash({
            message: "Votre première affaire a bien été créée!",
            level: 'success'
          })
          setTimeout(() => {
            window.location = route('orders.create.start')
          }, 2000)
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
          this.errors = error.response.data.errors
        })
      },
      toggleAlert() {
        this.showAlert = !this.showAlert
      }
    }
  }
</script>
