<template>
  <div>
    <button class="btn btn--red-large"
            @click="toggleModal">
      <i class="fal fa-plus-circle"></i>
      Nouveau format
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
           @keyup.enter="addFormat">

        <div class="modal__container">
          <h2 class="modal__title">Nouveau format</h2>

          <!--Name-->
          <div class="modal__group">
            <label for="name" class="modal__label">Nom</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="name"
                   id="name"
                   class="modal__input"
                   v-model.trim="format.name"
                   required autofocus>
            <div class="modal__alert"
                 v-if="errors.name">
              {{ errors.name[0] }}
            </div>
          </div>

          <!--Height-->
          <div class="modal__group">
            <label for="height" class="modal__label">Hauteur</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="height"
                   id="height"
                   class="modal__input"
                   v-model.trim="format.height">
            <div class="modal__alert"
                 v-if="errors.height">
              {{ errors.height[0] }}
            </div>
          </div>

          <!--Width-->
          <div class="modal__group">
            <label for="width" class="modal__label">Largeur</label>
            <span class="modal__required">*</span>
            <input type="text"
                   name="width"
                   id="width"
                   class="modal__input"
                   v-model.trim="format.width">
            <div class="modal__alert"
                 v-if="errors.width">
              {{ errors.width[0] }}
            </div>
          </div>

          <!--Surface-->
          <div class="modal__group">
            <label for="surface" class="modal__label">Surface</label>
            <input type="text"
                   name="surface"
                   id="surface"
                   class="modal__input"
                   v-model.trim="format.surface">
            <div class="modal__alert"
                 v-if="errors.surface">
              {{ errors.surface[0] }}
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
                    @click.prevent="addFormat">
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
    data() {
      return {
        format: {
          name: '',
          height: '',
          width: '',
          surface: ''
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
       * Add a format.
       */
      addFormat() {
        this.$store.dispatch('toggleLoader')

        axios.post(route('formats.store'), this.format)
          .then(response => {
            this.format = response.data
            this.$emit('formatWasCreated', this.format)
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.format = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>
