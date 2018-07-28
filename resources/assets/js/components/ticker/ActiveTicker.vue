<template>
  <div>
    <transition name="fade">
      <div
        v-if="visible"
        class="ticker__container">
        <p class="ticker__body">{{ ticker.body }}</p>
        <button
          role="button"
          class="ticker__close"
          @click.prevent="close">
          <i class="fal fa-times"/>
        </button>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
    ticker: {
      type: [Object, Array],
      required: true
    },
    cookie: {
      type: [Object, String],
      required: true
    }
  },
  data() {
    return {
      currentCookie: this.cookie
    };
  },
  computed: {
    visible() {
      return this.ticker.id && this.ticker.id != this.currentCookie;
    }
  },
  methods: {
    close() {
      window.axios
        .post(window.route("api.tickers.cookies.store"), this.ticker)
        .then(res => {
          this.currentCookie = res.data;
        });
    }
  }
};
</script>

