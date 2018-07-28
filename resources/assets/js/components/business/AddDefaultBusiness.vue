<template>
  <div class="alert-page__container">
    <transition
      name="fade"
      mode="out-in"
      appear>
      <div
        v-if="showAlert"
        key="start"
        class="alert-page__card">
        <img
          src="/img/icons/alert@3x.png"
          class="alert-page__icon"
          alt="Attention">
        <h1 class="alert-page__title">Définir une affaire</h1>
        <p class="alert-page__paragraph">
          {{ context }} disposer d'une affaire par défaut. Cliquez sur le bouton pour en ajouter une.
        </p>
        <button
          role="button"
          class="btn btn--red"
          @click="toggleAlert">
          <i class="fal fa-plus-circle"/>
          Ajouter
        </button>
      </div>
      <div
        v-else
        key="end"
        class="alert-page__card--large">

        <h1 class="alert-page__title">Ajouter une affaire</h1>

        <form class="alert-page__form">

          <div class="form__group">
            <label
              class="form__label"
              for="name">
              Nom
            </label>
            <span class="form__required">*</span>
            <input
              id="name"
              v-model.trim="business.name"
              type="text"
              name="name"
              class="form__input"
              required
              autofocus>
            <div
              v-if="errors.name"
              class="form__alert"
              v-text="errors.name[0]"/>
          </div>

          <div class="form__group">
            <label
              class="form__label"
              for="description">
              Description
            </label>
            <input
              id="description"
              v-model.trim="business.description"
              type="text"
              name="description"
              class="form__input">
            <div
              v-if="errors.description"
              class="form__alert"
              v-text="errors.description[0]"/>
          </div>

          <div class="form__group">
            <label
              class="form__label"
              for="contact_id">
              Contact
            </label>
            <span class="form__required">*</span>
            <select
              id="contact_id"
              v-model.number.trim="business.contact_id"
              name="contact_id"
              class="form__select">
              <option disabled>Sélectionnez un contact</option>
              <option
                v-for="contact in contacts"
                :key="contact.id"
                :value="contact.id"
                v-text="contact.name"/>
            </select>
            <div
              v-if="errors.contact_id"
              class="form__alert"
              v-text="errors.contact_id[0]"/>
          </div>
        </form>
        <button
          role="button"
          class="btn btn--red"
          @click="addBusiness">
          <i class="fal fa-check"/>
          Terminer
        </button>
      </div>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { mapGetters, mapActions } from "vuex";

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
        name: "",
        description: "",
        contact_id: "",
        company_id: this.company.id,
        setDefault: true
      },
      errors: {}
    };
  },
  computed: {
    ...mapGetters(["loaderState"]),
    context() {
      if (this.company.name === "Particulier") {
        return "Vous devez";
      } else {
        return "Votre société doit";
      }
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    addBusiness() {
      this.toggleLoader();
      window.axios
        .post(window.route("businesses.store"), this.business)
        .then(() => {
          window.flash({
            message: "Votre première affaire a bien été créée!",
            level: "success"
          });
          setTimeout(() => {
            window.location = window.route("orders.create.start");
          }, 2000);
        })
        .catch(err => {
          this.errors = err.response.data.errors;
          this.toggleLoader();
        });
    },
    toggleAlert() {
      this.showAlert = !this.showAlert;
    }
  }
};
</script>
