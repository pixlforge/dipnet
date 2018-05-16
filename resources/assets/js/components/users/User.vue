<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ user.username| capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Role</span>
        {{ user.role| capitalize }}
      </div>
      <div>
        <span class="card__label">Email</span>
        {{ user.email }}
      </div>
      <div v-if="user.company">
        <span class="card__label">Société</span>
        {{ user.company.name | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Compte</span>
        <span v-if="user.email_confirmed">
          <i class="fal fa-check-circle text--success"></i>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"></i>
        </span>
      </div>
      <div v-if="userIsNotAdmin">
        <span class="card__label">Contact</span>
        <span v-if="user.contact_confirmed">
          <i class="fal fa-check-circle text--success"></i>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"></i>
        </span>
      </div>
      <div v-if="userIsNotAdmin">
        <span class="card__label">Société</span>
        <span v-if="user.company_confirmed">
          <i class="fal fa-check-circle text--success"></i>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"></i>
        </span>
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(user.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(user.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div title="Supprimer"
           role="button"
           @click="destroy">
        <i class="fal fa-times"></i>
      </div>
      <div title="Modifier">
        <edit-user :user="user"
                   :companies="companies"></edit-user>
      </div>
    </div>
  </div>
</template>

<script>
  import EditUser from './EditUser.vue'
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    components: {
      EditUser
    },
    props: {
      user: {
        type: Object,
        required: true
      },
      companies: {
        type: Array,
        required: true
      }
    },
    computed: {
      userIsNotAdmin() {
        return this.user.role === '' || this.user.role === 'utilisateur'
      }
    },
    mixins: [mixins],
    methods: {
      destroy() {
        axios.delete(route('users.destroy', [this.user.id]))
        this.$emit('userWasDeleted', this.user.id)
      },
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      }
    }
  }
</script>
