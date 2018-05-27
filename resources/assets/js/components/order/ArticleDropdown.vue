<template>
  <div ref="dropdownMenu">
    <div
      class="dropdown__label"
      @click="toggleOpen">
      <span v-if="type !== 'print'">{{ label | capitalize }}</span>
      <span v-else>{{ label.description | capitalize }}
        <img
          v-if="label.greyscale && label.greyscale !== null"
          src="/img/icons/black-white.png"
          alt="Icône noir et blanc">
        <img
          v-if="!label.greyscale && label.greyscale !== null"
          src="/img/icons/colors.png"
          alt="Icône couleur">
      </span>
      <i class="fas fa-caret-down"/>
    </div>
    <div
      v-if="open"
      class="dropdown__container">
      <ul
        v-if="type === 'print'"
        class="dropdown__list">
        <li class="dropdown__section-title">
          <div>Noir &amp; blanc</div>
          <div>
            <img
              src="/img/icons/black-white.png"
              alt="Icône noir et blanc">
          </div>
        </li>
        <li
          v-for="article in listArticlePrintTypes"
          v-if="article.greyscale"
          :key="article.id"
          @click="selectItem(article)">
          {{ article.description }}
        </li>
        <li class="dropdown__section-title">
          <div>
            Couleur
          </div>
          <div>
            <img
              src="/img/icons/colors.png"
              alt="Icône couleur">
          </div>
        </li>
        <li
          v-for="article in listArticlePrintTypes"
          v-if="!article.greyscale"
          :key="article.id"
          @click="selectItem(article)">
          {{ article.description }}
        </li>
      </ul>
      <ul
        v-if="type === 'option'"
        class="dropdown__list">
        <li
          v-for="article in listArticleOptionTypes"
          :key="article.id"
          @click="selectItem(article)">
          {{ article.description }}
        </li>
      </ul>
      <ul
        v-if="type === 'finish'"
        class="dropdown__list">
        <li
          v-for="(finish, index) in listFinishTypes"
          :key="index"
          @click="selectItem(finish)">
          {{ finish.name | capitalize }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import mixins from "../../mixins";
import { mapGetters } from "vuex";

export default {
  mixins: [mixins],
  props: {
    type: {
      type: String,
      required: true
    },
    label: {
      type: [Object, String],
      required: true
    }
  },
  data() {
    return {
      open: false
    };
  },
  computed: {
    ...mapGetters([
      "listArticlePrintTypes",
      "listArticleOptionTypes",
      "listFinishTypes"
    ])
  },
  created() {
    document.addEventListener("click", this.documentClick);
  },
  destroyed() {
    document.removeEventListener("click", this.documentClick);
  },
  methods: {
    /**
     * Toggle the open state of the dropdown list.
     */
    toggleOpen() {
      this.open = !this.open;
    },
    /**
     * Retrieve the reference of the active dropdown and close
     * it if another element is clicked.
     */
    documentClick(event) {
      let el = this.$refs.dropdownMenu;
      let target = event.target;
      if (el !== target && !el.contains(target)) {
        this.open = false;
      }
    },
    /**
     * Select an item from the list.
     */
    selectItem(item) {
      this.$emit("itemSelected", item);
      this.toggleOpen();
    }
  }
};
</script>