<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ contact.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Adresse</span>
        {{ contact.address_line1 | capitalize }}
      </div>
      <div>
        {{ contact.address_line2 | capitalize }}
      </div>
      <div>
        <span class="card__label">Localité</span>
        {{ contact.zip }} {{ contact.city }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Tel</span>
        {{ contact.phone_number }}
      </div>
      <div>
        <span class="card__label">Fax</span>
        {{ contact.fax }}
      </div>
      <div>
        <span class="card__label">Email</span>
        {{ contact.email }}
      </div>
      <div v-if="contact.company">
        <span class="card__label">Société</span>
        {{ contact.company.name }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(contact.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(contact.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div
        title="Supprimer"
        role="button"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>
      <div title="Modifier">
        <edit-contact
          :contact="contact"
          :companies="companies"
          :user="user"/>
      </div>
    </div>
  </div>
</template>

<script>
import EditContact from "./EditContact.vue";
import mixins from "../../mixins";

export default {
  components: {
    EditContact
  },
  mixins: [mixins],
  props: {
    contact: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },
  methods: {
    destroy() {
      window.axios.delete(window.route("contacts.destroy", [this.contact.id]));
      this.$emit("contactWasDeleted", this.contact.id);
    }
  }
};
</script>
