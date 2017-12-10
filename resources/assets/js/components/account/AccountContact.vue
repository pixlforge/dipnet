<template>
  <div class="container-fluid">
    <div class="row">

      <a href="/">
        <div class="company-logo-container"
             :class="logoWhite"
             aria-hidden="true">
        </div>
      </a>

      <div class="col-12 col-lg-6 fixed-lg-left bg-shapes-red no-padding">
        <div class="col-12 col-md-5 offset-md-5 mt-md-checklist no-padding">

          <div class="d-flex flex-column justify-content-center checklist">
            <a class="d-flex align-items-center checklist-item checklist-item-done link-unstyled">
              <span class="badge badge-white mx-4"><i class="fal fa-check"></i></span>
              <span>Enregistrement</span>
            </a>
            <a class="d-flex align-items-center checklist-item checklist-item-active link-unstyled">
              <span class="badge badge-white mx-4">2</span>
              <span>Contact</span>
            </a>
            <a class="d-flex align-items-center checklist-item link-unstyled">
              <span class="badge badge-white mx-4">3</span>
              <span>Société</span>
            </a>
            <a class="d-flex align-items-center checklist-item link-unstyled">
              <span class="badge badge-white mx-4">4</span>
              <span>Prêt</span>
            </a>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6 push-lg-6 vh-100 d-flex align-items-center">
        <div class="col-12 col-lg-8 mx-auto py-5">

          <!--Contact Info Form-->
          <form role="form"
                @submit.prevent>

            <h4 class="text-center">Contact</h4>

            <!--Name-->
            <div class="form-group my-5">
              <label for="name">Nom</label>
              <span class="required">*</span>
              <input type="text"
                     id="name"
                     name="name"
                     v-model="contact.name"
                     class="form-control"
                     required autofocus>
              <div class="help-block"
                   v-if="errors.name"
                   v-text="errors.name[0]">
              </div>
            </div>

            <!--Address Line 1-->
            <div class="form-group my-5">
              <label for="address_line1">Adresse ligne 1</label>
              <span class="required">*</span>
              <input type="text"
                     id="address_line1"
                     name="address_line1"
                     v-model="contact.address_line1"
                     class="form-control"
                     required>
              <div class="help-block"
                   v-if="errors.address_line1"
                   v-text="errors.address_line1[0]">
              </div>
            </div>

            <!--Address Line 2-->
            <div class="form-group my-5">
              <label for="address_line2">Adresse ligne 2</label>
              <input type="text"
                     id="address_line2"
                     name="address_line2"
                     v-model="contact.address_line2"
                     class="form-control">
              <div class="help-block"
                   v-if="errors.address_line2"
                   v-text="errors.address_line2[0]">
              </div>
            </div>

            <!--Zip-->
            <div class="form-group my-5">
              <label for="zip">NPA</label>
              <span class="required">*</span>
              <input type="text"
                     id="zip"
                     name="zip"
                     v-model="contact.zip"
                     class="form-control"
                     required>
              <div class="help-block"
                   v-if="errors.zip"
                   v-text="errors.zip[0]">
              </div>
            </div>

            <!--City-->
            <div class="form-group my-5">
              <label for="city">Ville</label>
              <span class="required">*</span>
              <input type="text"
                     id="city"
                     name="city"
                     v-model="contact.city"
                     class="form-control"
                     required>
              <div class="help-block"
                   v-if="errors.city"
                   v-text="errors.city[0]">
              </div>
            </div>

            <!--Phone Number-->
            <div class="form-group my-5">
              <label for="phone_number">Téléphone</label>
              <input type="text"
                     id="phone_number"
                     name="phone_number"
                     v-model="contact.phone_number"
                     class="form-control">
              <div class="help-block"
                   v-if="errors.phone_number"
                   v-text="errors.phone_number[0]">
              </div>
            </div>

            <!--Fax-->
            <div class="form-group my-5">
              <label for="fax">Fax</label>
              <input type="text"
                     id="fax"
                     name="fax"
                     v-model="contact.fax"
                     class="form-control">
              <div class="help-block"
                   v-if="errors.fax"
                   v-text="errors.fax[0]">
              </div>
            </div>

            <button class="btn btn-black btn-block mt-5"
                    @click="updateContactInfo">
              Mettre à jour
            </button>
          </form>
        </div>
      </div>
    </div>

    <!--Loader-->
    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    data() {
      return {
        contact: {
          name: '',
          address_line1: '',
          address_line2: '',
          zip: '',
          city: '',
          phone_number: '',
          fax: ''
        },
        errors: {}
      }
    },
    components: {
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Update the Contact associated with the User.
       */
      updateContactInfo() {
        this.$store.dispatch('toggleLoader')

        axios.post('/register/contact', this.contact)
          .then(() => {
            this.$store.dispatch('toggleLoader')
            this.contact = {}
            flash({
              message: 'Félicitations! Votre compte a bien été mis à jour!',
              level: 'success'
            })
            setTimeout(() => {
              window.location.pathname = '/'
            }, 2000)
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>

<style scoped>
  .company-logo-container {
    position: fixed;
  }
</style>
