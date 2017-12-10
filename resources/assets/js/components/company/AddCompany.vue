<template>
  <div>

    <!--Button-->
    <a @click="toggleModal"
       class="btn btn-lg btn-black light mt-5"
       role="button">
      <i class="fal fa-plus-circle mr-2"></i>
      Nouvelle société
    </a>

    <!--Background-->
    <transition name="fade">
      <div class="modal-background"
           v-if="showModal"
           @click="toggleModal">
      </div>
    </transition>

    <!--Modal Panel-->
    <transition name="slide">
      <div class="modal-panel"
           v-if="showModal"
           @keyup.esc="toggleModal"
           @keyup.enter="addCompany">
        <div class="container-fluid">
          <div class="row">
            <div class="col-10 col-lg-8 offset-lg-1">

              <!--Title-->
              <h3 class="mt-7 mb-5">Nouvelle société</h3>

              <!--Form-->
              <form @submit.prevent>

                <!--Name-->
                <div class="form-group">
                  <label for="name">Nom</label>
                  <span class="required">*</span>
                  <input type="text"
                         id="name"
                         name="name"
                         class="form-control"
                         v-model.trim="company.name"
                         required autofocus>
                  <div class="help-block"
                       v-if="errors.name"
                       v-text="errors.name[0]">
                  </div>
                </div>

                <!--Status-->
                <div class="form-group my-5">
                  <label for="status">Statut</label>
                  <select name="status"
                          id="status"
                          class="form-control custom-select"
                          v-model.trim="company.status">
                    <option disabled>Sélectionnez un statut</option>
                    <option value="temporaire">Temporaire</option>
                    <option value="permanent">Permanent</option>
                  </select>
                </div>

                <!--Description-->
                <div class="form-group my-5">
                  <label for="description">Description</label>
                  <input type="text"
                         id="description"
                         name="description"
                         class="form-control"
                         v-model.trim="company.description">
                  <div class="help-block"
                       v-if="errors.description"
                       v-text="errors.description[0]">
                  </div>
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
                            @click.prevent="addCompany">
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
    data() {
      return {
        company: {
          name: '',
          status: '',
          description: '',
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
       * Add a company.
       */
      addCompany() {
        this.$store.dispatch('toggleLoader')

        axios.post('/companies', this.company)
          .then(response => {
            this.company = response.data
            this.$emit('companyWasCreated', this.company)
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.company = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>
