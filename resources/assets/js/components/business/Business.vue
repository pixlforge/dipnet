<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ business.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Référence</span>
        {{ business.reference }}
      </div>
      <div>
        <span class="card__label">Description</span>
        {{ business.description | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Société</span>
        {{ business.company.name | capitalize }}
      </div>
      <div>
        <span class="card__label">Contact</span>
        {{ business.contact.name | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(business.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(business.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div title="Supprimer"
           @click="destroy">
        <i class="fal fa-times"></i>
      </div>
      <div title="Modifier">
        <app-edit-business :data-business="business"
                           :data-companies="companies"
                           :data-contacts="dataContacts">
        </app-edit-business>
      </div>
    </div>
  </div>
</template>

<script>
  import EditBusiness from './EditBusiness.vue'
  import mixins from '../../mixins'
  import moment from 'moment'

  export default {
    props: [
      'data-business',
      'data-companies',
      'data-contacts'
    ],
    data() {
      return {
        business: this.dataBusiness,
        companies: this.dataCompanies
      }
    },
    mixins: [mixins],
    components: {
      'app-edit-business': EditBusiness
    },
    methods: {
      /**
       * Delete a business.
       */
      destroy() {
        axios.delete(route('businesses.destroy', [this.business.id]))
        this.$emit('businessWasDeleted', this.business.id)
      },

      /**
       * Get the formatted dates.
       */
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      }
    }
  }
</script>
