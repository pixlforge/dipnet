<template>
  <div>

    <!--Button-->
    <a @click="toggleModal"
       class="btn btn-lg btn-black light mt-5"
       role="button">
      <i class="fal fa-plus-circle mr-2"></i>
      Nouvelle affaire
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
           @keyup.esc.prevent="toggleModal"
           @keyup.enter="addBusiness">
        <div class="container-fluid">
          <div class="row">
            <div class="col-10 col-lg-8 offset-lg-1">

              <!--Title-->
              <h3 class="mt-7 mb-5">Nouvelle affaire</h3>

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
                         v-model.trim="business.name"
                         required autofocus>
                  <div class="help-block"
                       v-if="errors.name"
                       v-text="errors.name[0]">
                  </div>
                </div>

                <!--Reference-->
                <div class="form-group my-5">
                  <label for="reference">Référence</label>
                  <span class="required">*</span>
                  <input type="text"
                         id="reference"
                         name="reference"
                         class="form-control"
                         v-model.trim="business.reference"
                         required>
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
                         v-model.trim="business.description">
                  <div class="help-block"
                       v-if="errors.description"
                       v-text="errors.description[0]">
                  </div>
                </div>

                <!--Company-->
                <div class="form-group my-5">
                  <label for="company_id">Société</label>
                  <select name="company_id"
                          id="company_id"
                          class="form-control custom-select"
                          v-model.number.trim="business.company_id">
                    <option disabled>Sélectionnez une société</option>
                    <option v-for="company in companies"
                            :value="company.id"
                            v-text="company.name">
                    </option>
                  </select>
                  <div class="help-block"
                       v-if="errors.company_id"
                       v-text="errors.company_id[0]">
                  </div>
                </div>

                <!--Contact-->
                <div class="form-group my-5">
                  <label for="contact_id">Contact</label>
                  <select name="contact_id"
                          id="contact_id"
                          class="form-control custom-select"
                          v-model.number.trim="business.contact_id">
                    <option disabled>Sélectionnez un contact</option>
                    <option v-for="(contact, index) in contacts"
                            :value="contact.contact[index].id"
                            v-text="contact.contact[index].name">
                    </option>
                  </select>
                  <div class="help-block"
                       v-if="errors.contact_id"
                       v-text="errors.contact_id[0]">
                  </div>
                </div>

                <!--Buttons-->
                <div class="form-group d-flex flex-column flex-lg-row my-6">
                  <div class="col-12 col-lg-5 px-0 pr-lg-2">
                    <button class="btn btn-block btn-lg btn-white"
                            @click.prevent.stop="toggleModal">
                      <i class="fal fa-times mr-2"></i>
                      Annuler
                    </button>
                  </div>
                  <div class="col-12 col-lg-7 px-0 pl-lg-2">
                    <button class="btn btn-block btn-lg btn-black"
                            @click.prevent="addBusiness">
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
    props: ['data-companies'],
    data() {
      return {
        business: {
          name: '',
          reference: '',
          description: '',
          company_id: '',
          contact_id: ''
        },
        companies: this.dataCompanies,
        errors: {}
      }
    },
    mixins: [mixins],
    computed: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Get the contacts associated with the company.
       */
      contacts() {
        if (this.business.company_id !== '') {
          return this.companies.filter((company) => {
            return company.id === this.business.company_id
          })
        }
      }
    },
    methods: {

      /**
       * Add a business.
       */
      addBusiness() {
        this.$store.dispatch('toggleLoader')

        axios.post('/businesses', this.business)
          .then(response => {
            this.business = response.data
            this.$emit('businessWasCreated', this.business)
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.business = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>
