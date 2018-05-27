<template>
  <transition name="fade">
    <div
      v-show="show"
      :class="alertClass"
      class="alert"
      role="alert">
      <i class="fal fa-info-circle"/>
      {{ body }}
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true
    },
    level: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      body: this.message,
      alertLevel: this.level,
      show: false
    };
  },
  computed: {
    alertClass() {
      return "alert--" + this.alertLevel;
    }
  },
  created() {
    if (this.message) {
      this.flash();
    }
    window.events.$on("flash", data => this.flash(data));
  },
  methods: {
    /**
     * Flash the alert.
     */
    flash(data) {
      if (data) {
        this.body = data.message;
        this.alertLevel = data.level;
      }
      this.show = true;
      this.hide();
    },
    /**
     * Hide the alert.
     */
    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3500);
    }
  }
};
</script>

<style>
.alert-flash {
  z-index: 99;
  position: fixed;
  top: 30px;
  right: 35px;
}
</style>
