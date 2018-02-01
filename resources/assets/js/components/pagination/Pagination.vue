<template>
  <nav class="pagination__component">
    <ul class="pagination__list">
      <li :class="{ 'pagination--disabled': dataMeta.current_page === 1 }"
          @click.prevent="switched(dataMeta.current_page - 1)">
        <span><i class="fal fa-chevron-left"></i></span>
      </li>
      <template v-if="section > 1">
        <li @click.prevent="switched(1)">
          <span>1</span>
        </li>
        <li @click.prevent="goBackwardOneSection">
          <span>...</span>
        </li>
      </template>
      <li v-for="(page, index) in pages"
          :class="{ 'pagination__active': dataMeta.current_page === page }"
          @click.prevent="switched(page)">
        <span>{{ page }}</span>
      </li>
      <template v-if="section < sections">
        <li @click.prevent="goForwardOneSection">
          <span>...</span>
        </li>
        <li @click.prevent="switched(dataMeta.last_page)">
          <span>{{ dataMeta.last_page }}</span>
        </li>
      </template>
      <li :class="{ 'pagination--disabled': dataMeta.current_page >= dataMeta.last_page }"
          @click.prevent="switched(dataMeta.current_page + 1)">
        <span><i class="fal fa-chevron-right"></i></span>
      </li>
    </ul>
  </nav>
</template>

<script>
  export default {
    props: ['data-meta'],
    data() {
      return {
        numberPerSection: 6
      }
    },
    computed: {
      section() {
        return Math.ceil(this.dataMeta.current_page / this.numberPerSection)
      },
      sections() {
        return Math.ceil(this.dataMeta.last_page / this.numberPerSection)
      },
      lastPage() {
        let lastPage = ((this.section - 1) * this.numberPerSection) + this.numberPerSection

        if (this.section === this.sections) {
          lastPage = this.dataMeta.last_page
        }

        return lastPage
      },
      pages() {
        return _.range(
          (this.section - 1) * this.numberPerSection + 1,
          this.lastPage + 1
        )
      }
    },
    methods: {
      switched(page) {
        if (page <= 0 || page > this.dataMeta.last_page) {
          return
        }

        this.$emit('paginationSwitched', page)
      },
      goForwardOneSection() {
        this.switched(this.firstPageOfSection(this.section + 1))
      },
      goBackwardOneSection() {
        this.switched(this.firstPageOfSection(this.section - 1))
      },
      firstPageOfSection(section) {
        return (section - 1) * this.numberPerSection + 1
      }
    }
  }
</script>