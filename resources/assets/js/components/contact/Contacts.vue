<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Contacts</h1>

      <!-- Count -->
      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <!-- Sort -->
      <div class="header__sort">
        <AppSelect
          :options="sortOptions"
          v-model="sort"
          @input="selectSort(sort)">
          <span class="dropdown__title">Trier par</span>
          <span><strong>{{ sort ? sort.label : 'Aucun' }}</strong></span>
        </AppSelect>
      </div>

      <!-- Add button -->
      <Button
        primary
        red
        long
        @click.prevent="openAddPanel">
        <i class="fal fa-plus-circle"/>
        Ajouter un contact
      </Button>
    </div>

    <!-- Main content -->
    <main class="main__container">
      <section class="main__section">
        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--top"
          @pagination:switched="getContacts"/>

        <div
          v-if="!contacts.length && !fetching"
          class="main__no-results">
          <p>Il n'existe encore aucun contact.</p>
          <IllustrationNoData/>
        </div>

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
              @edit-contact:open="openEditPanel"
              @contact:deleted="removeContact(index)"/>
          </transition-group>
        </template>

        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--bottom"
          @pagination:switched="getContacts"/>
      </section>
    </main>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <AddContact
        v-if="showAddPanel"
        :companies="companies"
        :user="user"
        @contact:created="addContact"
        @add-contact:close="closePanels"/>
    </transition>

    <transition name="slide">
      <EditContact
        v-if="showEditPanel"
        :contact="modelToEdit"
        :companies="companies"
        :user="user"
        @contact:updated="updateContact"
        @edit-contact:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Contact from "./Contact.vue";
import Button from "../buttons/Button";
import AddContact from "./AddContact.vue";
import EditContact from "./EditContact.vue";
import AppSelect from "../select/AppSelect";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { mapGetters, mapActions } from "vuex";
import { loader, modal, panels, modelCount } from "../../mixins";

export default {
  components: {
    Contact,
    Button,
    AddContact,
    EditContact,
    AppSelect,
    Pagination,
    MoonLoader,
    IllustrationNoData
  },
  mixins: [loader, modal, panels, modelCount],
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
      errors: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Prénom", value: "first_name" },
        { label: "Date de création", value: "created_at" }
      ],
      fetching: false,
      modelNameSingular: "contact",
      modelNamePlural: "contacts",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getContacts();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async getContacts(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      try {
        let res = await window.axios.get(
          window.route("api.contacts.index", this.sort.value),
          { params: { page } }
        );
        this.contacts = res.data.data;
        this.meta = res.data.meta;
        this.fetching = false;
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data;
        this.fetching = false;
        this.toggleLoader();
      }
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
      let index = this.contacts.findIndex(contact => contact.id === data.id);
      this.contacts[index] = data;
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
