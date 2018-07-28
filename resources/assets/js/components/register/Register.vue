<template>
  <div>
    <transition
      name="fade"
      mode="out-in">
      <RegisterMenu
        v-if="showRegistrationMenu"
        :app-name="appName"
        @registration:selection="selection"/>

      <RegisterJoinInfos
        v-if="showJoinInfos"
        @back-to:menu="backToMenu"/>

      <RegisterAccount
        v-if="showAccountForm"
        :registration-type="registrationType"
        :invitation="invitation"
        @account:created="accountCreated"/>

      <RegisterContact
        v-if="showContactForm"
        :registration-type="registrationType"
        :invitation="invitation"
        @contact:created="contactCreated"/>
        
      <RegisterCompany
        v-if="showCompanyForm"
        @company:created="companyCreated"/>
    </transition>
    
    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import RegisterMenu from "./RegisterMenu.vue";
import RegisterJoinInfos from "./RegisterJoinInfos.vue";
import RegisterAccount from "./RegisterAccount.vue";
import RegisterContact from "./RegisterContact.vue";
import RegisterCompany from "./RegisterCompany.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { appName, loader, registration } from "../../mixins";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    RegisterMenu,
    RegisterJoinInfos,
    RegisterAccount,
    RegisterContact,
    RegisterCompany,
    MoonLoader
  },
  mixins: [appName, loader, registration],
  props: {
    token: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      showRegistrationMenu: false,
      showJoinInfos: false,
      showAccountForm: false,
      showContactForm: false,
      showCompanyForm: false,
      registrationType: "",
      invitation: {}
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  async mounted() {
    /**
     * Get the invitation token and try to confirm it.
     */
    if (this.token) {
      this.registrationType = "join";
      this.toggleLoader();
      try {
        let res = await window.axios.post(window.route("invitation.confirm"), {
          token: this.token
        });
        this.invitation = res.data;
        this.showAccountForm = true;
        this.toggleLoader();
      } catch (err) {
        this.toggleLoader();
      }
    } else {
      this.showRegistrationMenu = true;
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    /**
     * Registration selection type.
     */
    selection(event) {
      this.registrationType = event;
      this.showRegistrationMenu = false;
      if (this.registrationType === "join") {
        this.showJoinInfos = true;
      } else {
        this.showAccountForm = true;
      }
    },
    /**
     * Account was created.
     */
    accountCreated() {
      this.showAccountForm = false;
      this.showContactForm = true;
    },
    /**
     * Contact was created.
     */
    contactCreated() {
      if (this.registrationType === "add") {
        this.showContactForm = false;
        this.showCompanyForm = true;
      }
      if (
        this.registrationType === "self" ||
        this.registrationType === "join"
      ) {
        this.finishRegistration();
      }
    },
    /**
     * Company was created.
     */
    companyCreated() {
      this.finishRegistration();
    },
    /**
     * Get the user back to the menu.
     */
    backToMenu() {
      this.showJoinInfos = false;
      this.showRegistrationMenu = true;
    }
  }
};
</script>
