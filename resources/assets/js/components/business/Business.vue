<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ business.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Référence</span>
        {{ business.reference }}
      </div>
      <div v-if="business.description">
        <span class="card__label">Description</span>
        {{ business.description | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div v-if="business.company">
        <span class="card__label">Société</span>
        {{ business.company.name | capitalize }}
      </div>
      <div v-if="business.contact">
        <span class="card__label">Contact</span>
        {{ business.contact.name | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(business.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(business.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div
        role="button"
        title="Supprimer"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>
      <div>
        <EditBusiness
          :business="business"
          :companies="companies"
          :contacts="contacts"
          :user="user"
          :users="users"/>
      </div>
    </div>
  </div>
</template>

<script>
import EditBusiness from "./EditBusiness.vue";

export default {
  components: {
    EditBusiness
  },
  props: {
    business: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    },
    contacts: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    users: {
      type: Array,
      required: true
    }
  },
  methods: {
    destroy() {
      window.axios.delete(
        window.route("businesses.destroy", [this.business.id])
      );
      this.$emit("business:deleted", this.business.id);
    }
  }
};
</script>
