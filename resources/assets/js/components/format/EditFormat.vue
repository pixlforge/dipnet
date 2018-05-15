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
           @keyup.enter="updateFormat">

        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ format.name }}</h2>

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
            <label for="height" class="modal__label">Hauteur (mm)</label>
            <span class="modal__required">*</span>
            <input type="number"
                   name="height"
                   id="height"
                   class="modal__input"
                   v-model.number="format.height">
            <div class="modal__alert"
                 v-if="errors.height">
              {{ errors.height[0] }}
            </div>
          </div>

          <!--Width-->
          <div class="modal__group">
            <label for="width" class="modal__label">Largeur (mm)</label>
            <span class="modal__required">*</span>
            <input type="number"
                   name="width"
                   id="width"
                   class="modal__input"
                   v-model.number="format.width">
            <div class="modal__alert"
                 v-if="errors.width">
              {{ errors.width[0] }}
            </div>
          </div>

          <!--Surface-->
          <div class="modal__group">
            <label for="surface" class="modal__label">Surface (mm<sup>2</sup>)</label>
            <input type="number"
                   name="surface"
                   id="surface"
                   class="modal__input modal__input--disabled"
                   :value="widthTimesHeight"
                   disabled>
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
                    @click.prevent="updateFormat">
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
    props: ['data-format'],
    data() {
      return {
        format: this.dataFormat,
        errors: {}
      }
    },
    computed: {
      widthTimesHeight() {
        if (this.format.width && this.format.height) {
          return this.format.width * this.format.height
        } else {
          return 0
        }
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Update a format.
       */
      updateFormat() {
        this.$store.dispatch('toggleLoader')

        axios.put(route('formats.update', [this.format.id]), this.format)
          .then(() => {
            eventBus.$emit('formatWasUpdated', this.format);
          })
          .then(() => {
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data
          })
      }
    }
  }
</script>
