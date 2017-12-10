<template>
  <div ref="dropdownMenu">
    <div class="dropdown__label"
         @click="toggleOpen">
      <span>{{ label | capitalize }}</span>
      <i class="fas fa-caret-down"></i>
    </div>
    <div class="dropdown__container" v-if="open">
      <ul class="dropdown__list">
        <li v-if="type === 'print'"
            v-for="(article, index) in listArticlePrintTypes"
            @click="selectItem(article)">
          {{ article.description }}
        </li>
        <li v-if="type === 'option'"
            v-for="(article, index) in listArticleOptionTypes"
            @click="selectItem(article)">
          {{ article.description }}
        </li>
        <li v-if="type === 'finish'"
            v-for="(finish, index) in listFinishTypes"
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
    props: [
      'type',
      'label'
    ],
    data() {
      return {
        open: false
      }
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'listArticlePrintTypes',
        'listArticleOptionTypes',
        'listFinishTypes'
      ])
    },
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