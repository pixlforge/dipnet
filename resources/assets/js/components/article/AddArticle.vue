<template>
  <div>
    <button class="btn btn--red-large"
            @click="toggleModal">
      <i class="fal fa-plus-circle"></i>
      Nouvel article
    </button>

    <transition name="fade">
      <div class="modal__background"
           v-if="showModal"
           @click="toggleModal">
      </div>
    </transition>

    <transition name="slide">
      <div class="modal__slider"
           v-if="showModal"
           @keyup.esc="toggleModal"
           @keyup.enter="addArticle">

        <div class="modal__container">
          <h2 class="modal__title">Nouvel article</h2>

          <!--Reference-->
          <div class="modal__group">
            <label for="reference" class="modal__label">Référence</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="reference"
                   id="reference"
                   class="modal__input"
                   v-model.trim="article.reference"
                   required autofocus>
            <div class="modal__alert"
                 v-if="errors.reference">
              {{ errors.reference[0] }}
            </div>
          </div>

          <!--Description-->
          <div class="modal__group">
            <label for="description" class="modal__label">Description</label>
            <input type="text"
                   name="description"
                   id="description"
                   class="modal__input"
                   v-model.trim="article.description"
                   required>
            <div class="modal__alert"
                 v-if="errors.description">
              {{ errors.description[0] }}
            </div>
          </div>

          <!--Status-->
          <div class="modal__group">
            <label for="type" class="modal__label">Type</label>
            <select name="type"
                    id="type"
                    class="modal__select"
                    v-model.trim="article.type">
              <option disabled>Sélectionnez un type</option>
              <option value="option">Option</option>
              <option value="impression">Impression</option>
            </select>
            <div class="modal__alert"
                 v-if="errors.type">
              {{ errors.type[0] }}
            </div>
          </div>

          <!--Buttons-->
          <div class="modal__buttons">
            <button class="btn btn--grey"
                    @click.stop="toggleModal">
              <i class="fal fa-times"></i>
              Annuler
            </button>
            <button class="btn btn--red"
                    @click.prevent="addArticle">
              <i class="fal fa-check"></i>
              Ajouter
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    props: ['data-categories'],
    data() {
      return {
        article: {
          reference: '',
          description: '',
          type: ''
        },
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Add an article.
       */
      addArticle() {
        this.$store.dispatch('toggleLoader')

        axios.post(route('articles.store'), this.article)
          .then(response => {
            this.article.id = response.data
            this.$emit('articleWasCreated', this.article)
          })
          .then(() => {
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.article = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>
