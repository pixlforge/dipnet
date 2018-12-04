<template>
  <div class="user-business__card">
    <a
      :href="routeShowBusiness"
      class="user-business__card-content">
      <img
        :src="iconColor"
        :alt="iconAlt"
        class="user-business__img">
      <h2 class="user-business__title">{{ business.name }}</h2>
      <p class="user-business__orders">{{ userOrders }}</p>
      <button
        class="user-business__delete-button"
        @click.prevent="deleteBusiness">
        <i class="fal fa-times"/>
      </button>
    </a>
  </div>
</template>

<script>
export default {
  props: {
    business: {
      type: Object,
      required: true
    },
    orders: {
      type: Array,
      required: true
    }
  },
  computed: {
    iconColor() {
      if (this.business.folder_color === "red") {
        return "/img/folders/folder-red.svg";
      } else if (this.business.folder_color === "orange") {
        return "/img/folders/folder-orange.svg";
      } else if (this.business.folder_color === "purple") {
        return "/img/folders/folder-purple.svg";
      } else if (this.business.folder_color === "blue") {
        return "/img/folders/folder-blue.svg";
      }
    },
    iconAlt() {
      return this.business.name;
    },
    userOrders() {
      let count = 0;
      this.orders.forEach(order => {
        if (order.business_id === this.business.id) {
          count++;
        }
      });
      if (count === 0) {
        return "Aucune commande";
      } else if (count === 1) {
        return "1 commande";
      } else {
        return `${count} commandes`;
      }
    },
    routeShowBusiness() {
      return window.route("businesses.show", [this.business.reference]);
    }
  },
  methods: {
    async deleteBusiness() {
      if (
        window.confirm("Êtes-vous certain de vouloir supprimer cette affaire?")
      ) {
        await window.axios.delete(
          window.route("businesses.destroy", [this.business.reference])
        );
        this.$emit("business:deleted");
      }
    }
  }
};
</script>