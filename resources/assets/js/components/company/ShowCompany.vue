<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ company.name }}</h1>

      <div class="company__members">
        <i class="fal fa-users"/>
        {{ company.user.length }}
        {{ company.user.length == 0 || company.user.length == 1 ? 'membre' : 'membres' }}
      </div>
    </div>

    <div
      v-if="userIsNotAdmin"
      class="header__container">
      <InviteMember
        class="invitation__container"
        @invitation:created="addInvitation"/>
    </div>

    <!-- Main content -->
    <main class="main__container">
      <div class="company__container">
        <div class="company__group">
          <h2 class="company__title">Membres de {{ company.name }}</h2>
          <CompanyMember
            v-for="(user, index) in company.user"
            :key="index"
            :user="user"/>
        </div>

        <div class="company__group">
          <h2 class="company__title">Invitations</h2>
          <p
            v-if="!invitations.length"
            class="company__paragraph">
            Invitez vos collègues à rejoindre {{ appName }} et vos invitations s'afficheront ici.
          </p>
          <InvitedMember
            v-for="invitation in invitationsList"
            :key="invitation.id"
            :invitation="invitation"
            @invitation:deleted="removeInvitation"
          />
        </div>

        <div class="company__group company__group--last">
          <h3 class="company__title">Paramètres</h3>
          <p class="company__paragraph">Gérez les paramètres par défaut pour votre société.</p>

          <!-- Default business -->
          <div class="company__options">
            <div class="company__option">
              <label class="company__label">Affaire par défaut :</label>
              <AppSelect
                :options="optionsForBusiness"
                @input="selectBusiness">
                {{ currentCompany.business.label ? currentCompany.business.label : 'Sélectionner' }}
              </AppSelect>
            </div>
          </div>
        </div>
      </div>
    </main>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import AppSelect from "../select/AppSelect";
import CompanyMember from "./CompanyMember";
import InviteMember from "../invitation/Invitation";
import MoonLoader from "vue-spinner/src/MoonLoader";
import InvitedMember from "../invitation/InvitedMember";

import { mapGetters } from "vuex";
import { appName, loader } from "../../mixins";

export default {
  components: {
    AppSelect,
    CompanyMember,
    InviteMember,
    MoonLoader,
    InvitedMember
  },
  mixins: [appName, loader],
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
    },
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      invitationsList: this.invitations,
      optionsForBusiness: [],
      currentCompany: {
        id: this.company.id,
        name: this.company.name,
        slug: this.company.slug,
        status: this.company.status,
        description: this.company.description,
        business_id: this.company.business_id,
        business: {
          label: "",
          value: null
        }
      }
    };
  },
  computed: {
    ...mapGetters(["loaderState"]),
    userIsNotAdmin() {
      return this.user.role !== 'administrateur';
    }
  },
  mounted() {
    this.formatBusinessOptions();
    this.selectedBusiness();
  },
  methods: {
    addInvitation(member) {
      this.invitationsList.unshift(member);
      window.flash({
        message: `L'invitation à ${member.email} a bien été envoyée!`,
        level: "success"
      });
    },
    removeInvitation(id) {
      this.invitations.splice(
        this.invitations.findIndex(invitation => {
          return invitation.id == id;
        }),
        1
      );
    },
    selectBusiness(business) {
      this.currentCompany.business = business;
      this.currentCompany.business_id = business.value;
      this.update();
    },
    formatBusinessOptions() {
      this.optionsForBusiness = this.businesses.map(business => {
        return { label: business.name, value: business.id };
      });
    },
    selectedBusiness() {
      if (this.company.business_id) {
        this.currentCompany.business = this.optionsForBusiness.find(
          business => {
            return business.value === this.company.business_id;
          }
        );
      }
    },
    update() {
      window.axios
        .patch(
          window.route("companies.default.business.update", [
            this.company.slug
          ]),
          this.currentCompany
        )
        .then(() => {
          window.flash({
            message: "Les paramètres de votre société ont bien été mis à jour!",
            level: "success"
          });
        });
    }
  }
};
</script>
