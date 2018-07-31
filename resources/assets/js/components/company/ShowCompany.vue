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

    <div class="header__container">
      <InviteMember
        class="invitation__container"
        @invitation:created="addInvitation"/>
    </div>

    <div class="company__container">
      <div class="company__group">
        <h2 class="company__title">Membres de {{ company.name }}</h2>
        <transition-group
          name="highlight"
          tag="div">
          <CompanyMember
            v-for="(user, index) in company.user"
            :key="index"
            :user="user"
            class="card__container"
            @member:removed="removeMember(index)"/>
        </transition-group>
      </div>

      <div class="company__group">
        <h2 class="company__title">Invitations</h2>
        <p
          v-if="!invitations.length"
          class="company__paragraph">
          Invitez vos collègues à rejoindre {{ appName }} et vos invitations s'afficheront ici.
        </p>
        <transition-group
          name="highlight"
          tag="div">
          <InvitedMember
            v-for="(invitation, index) in invitations"
            :key="index"
            :invitation="invitation"
            class="card__container"
            @invitation:deleted="removeInvitation(index)"/>
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
            <SettingsDropdown
              :label="selectedBusiness"
              :items="businesses"
              @item:selected="selectBusiness"/>
          </div>
        </div>
      </div>
    </div>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import CompanyMember from "./CompanyMember.vue";
import InviteMember from "../invitation/Invitation.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import InvitedMember from "../invitation/InvitedMember.vue";
import SettingsDropdown from "../dropdown/SettingsDropdown";

import { mapGetters } from "vuex";
import { appName, loader } from "../../mixins";

export default {
  components: {
    CompanyMember,
    InviteMember,
    MoonLoader,
    InvitedMember,
    SettingsDropdown
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
    }
  },
  data() {
    return {
      selectedBusiness: "Sélection"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    const businessId = this.company.business_id;
    if (businessId !== null) {
      const business = this.businesses.find(business => {
        return business.id === businessId;
      });
      this.selectedBusiness = business.name;
    }
  },
  methods: {
    addInvitation(member) {
      this.invitations.unshift(member);
      window.flash({
        message: `L'invitation à ${member.email} a bien été envoyée!`,
        level: "success"
      });
    },
    removeMember() {
      alert("removed a member");
    },
    removeInvitation(index) {
      this.invitations.splice(index, 1);
    },
    selectBusiness(business) {
      this.selectedBusiness = business.name;
      this.company.business_id = business.id;
      this.update(business);
    },
    update() {
      window.axios
        .put(window.route("companies.update", [this.company.id]), this.company)
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
