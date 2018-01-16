<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ company.name }}</h1>

      <div class="company__members">
        <i class="fal fa-users"></i>
        {{ data.user.length }}
        {{ data.user.length == 0 || data.user.length == 1 ? 'membre' : 'membres' }}
      </div>
    </div>

    <div class="header__container">
      <app-invite-member class="invitation__container"
                         @invitationWasAdded="addInvitation">
      </app-invite-member>
    </div>

    <div class="company__container">
      <div class="company__group">
        <h2 class="company__title">Membres de {{ company.name }}</h2>

        <transition-group name="highlight" tag="div">
          <app-company-member class="card__container"
                              v-for="(member, index) in data.user"
                              :key="index"
                              :member="member"
                              @memberWasDeleted="removeMember(index)">
          </app-company-member>
        </transition-group>
      </div>

      <div class="company__group">
        <h2 class="company__title">Invitations</h2>

        <p class="company__paragraph" v-if="!invitations.length">
          Invitez vos collègues à rejoindre {{ appName }} et vos invitations s'afficheront ici.
        </p>

        <transition-group name="highlight" tag="div">
          <app-invited-member class="card__container"
                              v-for="(invitation, index) in invitations"
                              :key="index"
                              :invitation="invitation"
                              @invitationWasDeleted="removeInvitation(index)">
          </app-invited-member>
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
            <app-settings-dropdown :label="selectedBusiness"
                                   :data="dataBusinesses"
                                   @itemSelected="selectBusiness">
            </app-settings-dropdown>
          </div>
        </div>
      </div>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
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
    props: [
      'data',
      'invitations-data',
      'data-businesses'
    ],
    data() {
      return {
        company: this.data,
        invitations: this.invitationsData,
        selectedBusiness: 'Sélection'
      }
    },
    components: {
      'app-company-member': CompanyMember,
      'app-invite-member': InviteMember,
      'app-invited-member': InvitedMember,
      'app-moon-loader': MoonLoader,
      'app-settings-dropdown': SettingsDropdown
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Add a new invitation to the list.
       */
      addInvitation(member) {
        this.invitations.unshift(member)
        flash({
          message: `L'invitation à ${member.email} a bien été envoyée!`,
          level: 'success'
        })
      },

      /**
       * Remove a member from the company.
       */
      removeMember() {
        alert('removed a member')
      },

      /**
       * Remove an invitation.
       */
      removeInvitation(index) {
        this.invitations.splice(index, 1)
      },

      /**
       * Select a default business and update it.
       */
      selectBusiness(business) {
        this.selectedBusiness = business.name
        this.company.business_id = business.id
        this.update(business)
      },

      /**
       * Update the company's settings.
       */
      update(business) {
        axios.put(route('companies.update', [this.company.id]), this.company)
          .then(() => {
            flash({
              message: "Les paramètres de votre société ont bien été mis à jour!",
              level: 'success'
            })
          })
          .catch(error => console.log(error))
      }
    },
    mounted() {
      /**
       * Preselect the default business.
       */
      const businessId = this.data.business_id

      if (businessId !== null) {
        const business = this.dataBusinesses.find(business => {
          return business.id === businessId
        })
        this.selectedBusiness = business.name
      }
    }
  }
</script>
