<template>
  <div>
    <div @click="toggleModal">
      <i class="fal fa-pencil"></i>
    </div>

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
           @keyup.enter="updateArticle">

        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ article.reference }}</h2>

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
            <button class="btn btn--black"
                    @click.prevent="updateArticle">
              <i class="fal fa-check"></i>
              Mettre à jour
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapActions } from 'vuex'

  export default {
    props: ['data-article'],
    data() {
      return {
        article: this.dataArticle,
        categories: this.dataCategories,
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Update an article.
       */
      updateArticle() {
        this.$store.dispatch('toggleLoader')

        axios.put(route('articles.update', [this.article.id]), this.article)
          .then(() => {
            eventBus.$emit('articleWasUpdated', this.article)
          })
          .then(() => {
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
          })
          .catch((error) => {
            this.$store.dispatch('toggleLoader')
            if (error.response.status === 422) {
              flash({
                message: "Erreur. La validation a échoué.",
                level: 'danger'
              })
              return;
            }
            flash({
              message: "Erreur. Veuillez réessayer plus tard.",
              level: 'danger'
            })
          })
      }
    }
  }
</script>
