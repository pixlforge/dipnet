<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Contacts</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <div>
        <AppSelect
          :options="sortOptions"
          v-model="sort"
          @input="selectSort(sort)">
          <span class="dropdown__title">Trier par</span>
          <span><strong>{{ sort ? sort.label : 'Aucun' }}</strong></span>
        </AppSelect>
      </div>

      <AddContact
        :companies="companies"
        :user="user"
        @contact:created="addContact"/>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getContacts"/>

      <template v-if="!contacts.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun contact.</p>
      </template>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <Contact
            v-for="(contact, index) in contacts"
            :key="contact.id"
            :contact="contact"
            :companies="companies"
            :user="user"
            class="card__container"
            @contact:deleted="removeContact(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getContacts"/>
    </div>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import AppSelect from "../select/AppSelect";
import Contact from "./Contact.vue";
import AddContact from "./AddContact.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { modelCount, loader } from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Pagination,
    AppSelect,
    Contact,
    AddContact,
    MoonLoader
  },
  mixins: [modelCount, loader],
  props: {
    companies: {
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
      contacts: [],
      meta: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Nom", value: "name" },
        { label: "Date de création", value: "created_at" }
      ],
      errors: {},
      fetching: false,
      modelNameSingular: "contact",
      modelNamePlural: "contacts",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  created() {
    eventBus.$on("contact:updated", data => {
      this.updateContact(data);
    });
  },
  mounted() {
    this.getContacts();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    getContacts(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      window.axios
        .get(window.route("api.contacts.index", this.sort.value), {
          params: {
            page
          }
        })
        .then(res => {
          this.contacts = res.data.data;
          this.meta = res.data.meta;
          this.toggleLoader();
          this.fetching = false;
        })
        .catch(err => {
          this.errors = err.response.data;
          this.toggleLoader();
          this.fetching = false;
        });
    },
    selectSort(sort) {
      this.sort = sort;
      this.getContacts();
    },
    addContact(contact) {
      this.contacts.unshift(contact);
      window.flash({
        message: "La création du contact a réussi.",
        level: "success"
      });
    },
    updateContact(data) {
      for (let contact of this.contacts) {
        if (data.id === contact.id) {
          contact.name = data.name;
          contact.address_line1 = data.address_line1;
          contact.address_line2 = data.address_line2;
          contact.zip = data.zip;
          contact.city = data.city;
          contact.phone_number = data.phone_number;
          contact.fax = data.fax;
          contact.email = data.email;
          contact.company_id = data.company_id;
        }
      }
      window.flash({
        message: "Les modifications apportées au contact ont été enregistrées.",
        level: "success"
      });
    },
    removeContact(index) {
      this.contacts.splice(index, 1);
      window.flash({
        message: "Suppression du contact réussie.",
        level: "success"
      });
    }
  }
};
</script>
