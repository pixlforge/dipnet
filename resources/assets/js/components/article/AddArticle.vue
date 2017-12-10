<template>
  <div>

    <!--Button-->
    <a @click="toggleModal"
       class="btn btn-lg btn-black light mt-5"
       role="button">
      <i class="fal fa-plus-circle mr-2"></i>
      Nouvel article
    </a>

    <!--Background-->
    <transition name="fade">
      <div class="modal-background"
           v-if="showModal"
           @click="toggleModal"></div>
    </transition>

    <!--Modal Panel-->
    <transition name="slide">
      <div class="modal-panel"
           v-if="showModal"
           @keyup.esc="toggleModal"
           @keyup.enter="addArticle">
        <div class="container-fluid">
          <div class="row">
            <div class="col-10 col-lg-8 offset-lg-1">

              <!--Title-->
              <h3 class="mt-7 mb-5">Nouvel article</h3>

              <!--Form-->
              <form @submit.prevent>

                <!--Reference-->
                <div class="form-group">
                  <label for="reference">Référence</label>
                  <span class="required">*</span>
                  <input type="text"
                         id="reference"
                         name="reference"
                         class="form-control"
                         v-model.trim="article.reference"
                         required autofocus>
                  <div class="help-block"
                       v-if="errors.reference"
                       v-text="errors.reference[0]">
                  </div>
                </div>

                <!--Description-->
                <div class="form-group my-5">
                  <label for="description">Description</label>
                  <input type="text"
                         id="description"
                         name="description"
                         class="form-control"
                         v-model.trim="article.description">
                  <div class="help-block"
                       v-if="errors.description"
                       v-text="errors.description[0]">
                  </div>
                </div>

                <!--Type-->
                <div class="form-group my-5">
                  <label for="type">Type</label>
                  <select name="type"
                          id="type"
                          class="form-control custom-select"
                          v-model.trim="article.type">
                    <option disabled>Sélectionnez un type</option>
                    <option value="option">Option</option>
                    <option value="impression">Impression</option>
                  </select>
                </div>

                <!--Buttons-->
                <div class="form-group d-flex flex-column flex-lg-row my-6">
                  <div class="col-12 col-lg-5 px-0 pr-lg-2">
                    <button class="btn btn-block btn-lg btn-white"
                            @click.stop="toggleModal">
                      <i class="fal fa-times mr-2"></i>
                      Annuler
                    </button>
                  </div>
                  <div class="col-12 col-lg-7 px-0 pl-lg-2">
                    <button class="btn btn-block btn-lg btn-black"
                            @click.prevent="addArticle">
                      <i class="fal fa-check mr-2"></i>
                      Ajouter
                    </button>
                  </div>
                </div>
              </form>
            </div>
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

        axios.post('/articles', this.article)
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
