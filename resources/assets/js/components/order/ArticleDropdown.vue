<template>
  <div ref="dropdownMenu">
    <div class="dropdown__label"
         @click="toggleOpen">
      <span v-if="type !== 'print'">{{ label | capitalize }}</span>
      <span v-else>{{ label.description | capitalize }}
        <img v-if="label.greyscale && label.greyscale !== null"
             src="/img/icons/black-white.png"
             alt="Icône noir et blanc">
        <img v-if="!label.greyscale && label.greyscale !== null"
             src="/img/icons/colors.png"
             alt="Icône couleur">
      </span>
      <i class="fas fa-caret-down"></i>
    </div>
    <div class="dropdown__container" v-if="open">
      <ul class="dropdown__list" v-if="type === 'print'">
        <li class="dropdown__section-title">
          <div>Noir &amp; blanc</div>
          <div><img src="/img/icons/black-white.png" alt="Icône noir et blanc"></div>
        </li>
        <li v-for="article in listArticlePrintTypes"
            :key="article.id"
            v-if="article.greyscale"
            @click="selectItem(article)">
          {{ article.description }}
        </li>
        <li class="dropdown__section-title">
          <div>Couleur</div>
          <div><img src="/img/icons/colors.png" alt="Icône couleur"></div>
        </li>
        <li v-for="article in listArticlePrintTypes"
            :key="article.id"
            v-if="!article.greyscale"
            @click="selectItem(article)">
          {{ article.description }}
        </li>
      </ul>
      <ul class="dropdown__list" v-if="type === 'option'">
        <li v-for="article in listArticleOptionTypes"
            :key="article.id"
            @click="selectItem(article)">
          {{ article.description }}
        </li>
      </ul>
      <ul class="dropdown__list" v-if="type === 'finish'">
        <li v-for="(finish, index) in listFinishTypes"
            :key="index"
            @click="selectItem(finish)">
          {{ finish.name | capitalize }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: {
      type: {
        type: String,
        required: true
      },
      label: {
        required: true
      }
    },
    data() {
      return {
        open: false
      }
    },
    computed: {
      ...mapGetters([
        'listArticlePrintTypes',
        'listArticleOptionTypes',
        'listFinishTypes'
      ])
    },
    mixins: [mixins],
    methods: {
      /**
       * Toggle the open state of the dropdown list.
       */
      toggleOpen() {
        this.open = !this.open
      },
      /**
       * Retrieve the reference of the active dropdown and close
       * it if another element is clicked.
       */
      documentClick(event) {
        let el = this.$refs.dropdownMenu
        let target = event.target
        if ((el !== target) && !el.contains(target)) {
          this.open = false
        }
      },
      /**
       * Select an item from the list.
       */
      selectItem(item) {
        this.$emit('itemSelected', item)
        this.toggleOpen()
      },
    },
    created() {
      document.addEventListener('click', this.documentClick)
    },
    destroyed() {
      document.removeEventListener('click', this.documentClick)
    }
  }
</script>