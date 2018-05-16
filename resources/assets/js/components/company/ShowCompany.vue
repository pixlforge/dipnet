<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ company.name }}</h1>

      <div class="company__members">
        <i class="fal fa-users"></i>
        {{ company.user.length }}
        {{ company.user.length == 0 || company.user.length == 1 ? 'membre' : 'membres' }}
      </div>
    </div>

    <div class="header__container">
      <invite-member class="invitation__container"
                     @invitationWasAdded="addInvitation"></invite-member>
    </div>

    <div class="company__container">
      <div class="company__group">
        <h2 class="company__title">Membres de {{ company.name }}</h2>
        <transition-group name="highlight" tag="div">
          <company-member class="card__container"
                          v-for="(user, index) in company.user"
                          :key="index"
                          :user="user"
                          @memberWasDeleted="removeMember(index)"></company-member>
        </transition-group>
      </div>

      <div class="company__group">
        <h2 class="company__title">Invitations</h2>
        <p class="company__paragraph" v-if="!invitations.length">
          Invitez vos collègues à rejoindre {{ appName }} et vos invitations s'afficheront ici.
        </p>
        <transition-group name="highlight" tag="div">
          <invited-member class="card__container"
                          v-for="(invitation, index) in invitations"
                          :key="index"
                          :invitation="invitation"
                          @invitationWasDeleted="removeInvitation(index)"></invited-member>
        </transition-group>
      </div>

      <div class="company__group company__group--last">
        <h3 class="company__title">Paramètres</h3>
        <p class="company__paragraph">
          Gérez les paramètres par défaut pour votre société.
        </p>

        <div class="company__options">
          <div class="company__option">
            <label class="company__label">Affaire par défaut :</label>
            <settings-dropdown :label="selectedBusiness"
                               :items="businesses"
                               @itemSelected="selectBusiness"></settings-dropdown>
          </div>
        </div>
      </div>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>

</template>

<script>
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import CompanyMember from './CompanyMember.vue'
  import InviteMember from '../invitation/Invitation.vue'
  import InvitedMember from '../invitation/InvitedMember.vue'
  import SettingsDropdown from '../dropdown/SettingsDropdown'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      CompanyMember,
      InviteMember,
      InvitedMember,
      MoonLoader,
      SettingsDropdown
    },
    props: {
      company: {
        type: Object,
        required: true
      },
      invitations: {
        type: Array,
        required: true
      },
      businesses: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        selectedBusiness: 'Sélection'
      }
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      addInvitation(member) {
        this.invitations.unshift(member)
        flash({
          message: `L'invitation à ${member.email} a bien été envoyée!`,
          level: 'success'
        })
      },
      removeMember() {
        alert('removed a member')
      },
      removeInvitation(index) {
        this.invitations.splice(index, 1)
      },
      selectBusiness(business) {
        this.selectedBusiness = business.name
        this.company.business_id = business.id
        this.update(business)
      },
      update(business) {
        axios.put(route('companies.update', [this.company.id]), this.company).then(() => {
          flash({
            message: "Les paramètres de votre société ont bien été mis à jour!",
            level: 'success'
          })
        }).catch(error => console.log(error))
      }
    },
    mounted() {
      const businessId = this.company.business_id
      if (businessId !== null) {
        const business = this.businesses.find(business => {
          return business.id === businessId
        })
        this.selectedBusiness = business.name
      }
    }
  }
</script>
