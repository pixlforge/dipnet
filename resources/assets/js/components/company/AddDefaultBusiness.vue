<template>
  <div class="alert-page__container">

    <!-- Create a business -->
    <div class="alert-page__card">

      <img
        src="/img/icons/alert@3x.png"
        class="alert-page__icon"
        alt="Attention">

      <p class="alert-page__paragraph">
        <span>{{ context }} disposer d'une affaire par défaut. Veuillez</span>
        <span v-if="businesses.length">sélectionner une affaire existante ou </span>
        <span>créer une nouvelle affaire afin de la définir en tant qu'affaire par défaut pour votre société.</span>
      </p>

      <form
        class="alert-page__form"
        @submit.prevent="addBusiness">
        <h1 class="alert-page__title">Ajouter une affaire</h1>

        <!-- Name -->
        <ModalInput
          id="name"
          v-model="business.name"
          type="text"
          required>
          <template slot="label">Nom</template>
          <template
            v-if="errors.name"
            slot="errors">
            {{ errors.name[0] }}
          </template>
        </ModalInput>

        <!-- Description -->
        <ModalInput
          id="description"
          v-model="business.description"
          type="text">
          <template slot="label">Description</template>
          <template
            v-if="errors.description"
            slot="errors">
            {{ errors.description[0] }}
          </template>
        </ModalInput>

        <!-- Contact -->
        <ModalSelect
          id="contact_id"
          :options="optionsForContact"
          v-model="business.contact_id">
          <template slot="label">Contact</template>
          <template
            v-if="errors.contact_id"
            slot="errors">
            {{ errors.contact_id[0] }}
          </template>
        </ModalSelect>

        <!-- Controls -->
        <div class="alert-page__controls">
          <Button
            type="submit"
            primary
            red>
            <i class="fal fa-plus"/>
            Ajouter une affaire et la définir en tant qu'affaire par défaut
          </Button>
        </div>
      </form>
    </div>

    <!-- Or -->
    <template v-if="businesses.length">
      <p class="alert-page__or">Ou</p>
    </template>

    <!-- Define a business -->
    <div
      v-if="businesses.length"
      class="alert-page__card">
      <form
        class="alert-page__form"
        @submit.prevent="defineBusiness">
        <h1 class="alert-page__title">Sélectionner une affaire existante</h1>

        <!-- Business -->
        <ModalSelect
          id="business_id"
          :options="optionsForBusiness"
          v-model="business_id"
          required>
          <template slot="label">Affaire</template>
          <template
            v-if="errors.business_id"
            slot="errors">
            {{ errors.business_id[0] }}
          </template>
        </ModalSelect>

        <!-- Controls -->
        <div class="alert-page__controls">
          <Button
            type="submit"
            primary
            red>
            <i class="fal fa-check"/>
            Définir cette affaire en tant qu'affaire par défaut
          </Button>
        </div>
      </form>
    </div>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import ModalInput from "../forms/ModalInput";
import ModalSelect from "../forms/ModalSelect";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { loader } from "../../mixins";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Button,
    ModalInput,
    ModalSelect,
    MoonLoader
  },
  mixins: [loader],
  props: {
    company: {
      type: Object,
      required: true
    },
    businesses: {
      type: Array,
      required: false,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      business_id: null,
      business: {
        name: "",
        description: "",
        contact_id: "",
        company_id: this.company.id,
        setDefault: true
      },
      errors: {},
      optionsForContact: [],
      optionsForBusiness: []
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
  mounted() {
    this.optionsForContact = this.company.contacts.map(contact => {
      return { label: contact.name, value: contact.id };
    });

    this.optionsForBusiness = this.businesses.map(business => {
      return { label: business.name, value: business.id };
    });
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async defineBusiness() {
      this.toggleLoader();
      try {
        await window.axios.patch(
          window.route("companies.default.business.update", [
            this.company.slug
          ]),
          { business_id: this.business_id }
        );
        window.flash({
          message: "Affaire par défaut définie avec succès!",
          level: "success"
        });
        setTimeout(() => {
          window.location = window.route("orders.create.start");
        }, 1000);
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    },
    async addBusiness() {
      this.toggleLoader();
      try {
        await window.axios.post(
          window.route("companies.default.business.store", [this.company.slug]),
          this.business
        );
        window.flash({
          message: "Votre première affaire a bien été créée!",
          level: "success"
        });
        setTimeout(() => {
          window.location = window.route("orders.create.start");
        }, 1000);
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
