<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ company.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Description</span>
        {{ company.description | capitalize }}
      </div>
      <div>
        <span class="card__label">Statut</span>
        {{ company.status | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(company.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(company.updated_at) }}
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
        <edit-company :company="company"/>
      </div>
    </div>
  </div>
</template>

<script>
import EditCompany from "./EditCompany.vue";
import mixins from "../../mixins";

export default {
  components: {
    EditCompany
  },
  mixins: [mixins],
  props: {
    company: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      open: false
    };
  },
  methods: {
    destroy() {
      window.axios.delete(window.route("companies.destroy", [this.company.id]));
      this.$emit("companyWasDeleted", this.company.id);
    }
  }
};
</script>
