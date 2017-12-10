<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 my-5 mx-auto">
        <div class="row">
          <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
            <h1 class="mt-5">{{ company.name }}</h1>
            <div class="light mt-5 mr-3">
              <i class="fal fa-users mr-2"></i>
              {{ data.user.length }}
              {{ data.user.length == 0 || data.user.length == 1 ? 'membre' : 'membres' }}
            </div>
          </div>

          <!--Invite-->
          <app-invite-member @invitationWasAdded="addInvitation"></app-invite-member>

        </div>
      </div>
    </div>
    <div class="row bg-grey-light">
      <div class="col-10 mx-auto my-7">

        <h3 class="light mb-5">Membres de {{ company.name }}</h3>

        <!--Member-->
        <transition-group name="highlight">
          <app-company-member class="card card-custom center-on-small-only"
                              v-for="(member, index) in data.user"
                              :member="member"
                              :key="member.id"
                              @memberWasDeleted="removeMember(index)">
          </app-company-member>
        </transition-group>

        <h3 class="light mt-7 mb-5">Invitations</h3>

        <h5 class="text-center light my-6"
            v-if="!invitations.length">
          Invitez vos collègues à rejoindre {{ appName }} et vos invitations s'afficheront ici.
        </h5>

        <!--Invitation-->
        <transition-group name="highlight">
          <app-invited-member class="card card-custom center-on-small-only"
                              v-for="(invitation, index) in invitations"
                              :invitation="invitation"
                              :key="invitation.id"
                              @invitationWasDeleted="removeInvitation(index)">
          </app-invited-member>
        </transition-group>

        <!--Loader-->
        <app-moon-loader :loading="loaderState"
                         :color="loader.color"
                         :size="loader.size">
        </app-moon-loader>
      </div>
    </div>
  </div>
</template>

<script>
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import CompanyMember from './CompanyMember.vue'
  import InviteMember from '../invitation/Invitation.vue'
  import InvitedMember from '../invitation/InvitedMember.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: ['data', 'invitations-data'],
    data() {
      return {
        company: this.data,
        invitations: this.invitationsData
      }
    },
    components: {
      'app-company-member': CompanyMember,
      'app-invite-member': InviteMember,
      'app-invited-member': InvitedMember,
      'app-moon-loader': MoonLoader
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
      }
    }
  }
</script>
