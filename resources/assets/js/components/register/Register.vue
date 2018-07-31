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
import RegisterAccount from "./RegisterAccount.vue";
import RegisterContact from "./RegisterContact.vue";
import RegisterCompany from "./RegisterCompany.vue";
import RegisterJoinInfos from "./RegisterJoinInfos.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { mapGetters, mapActions } from "vuex";
import { appName, loader, registration } from "../../mixins";

export default {
  components: {
    RegisterMenu,
    RegisterAccount,
    RegisterContact,
    RegisterCompany,
    RegisterJoinInfos,
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
  mounted() {
    this.confirmToken();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async confirmToken() {
      if (this.token) {
        this.registrationType = "join";
        this.toggleLoader();
        try {
          let res = await window.axios.post(
            window.route("invitation.confirm"),
            {
              token: this.token
            }
          );
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
    selection(event) {
      this.registrationType = event;
      this.showRegistrationMenu = false;
      if (this.registrationType === "join") {
        this.showJoinInfos = true;
      } else {
        this.showAccountForm = true;
      }
    },
    accountCreated() {
      this.showAccountForm = false;
      this.showContactForm = true;
    },
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
    companyCreated() {
      this.finishRegistration();
    },
    backToMenu() {
      this.showJoinInfos = false;
      this.showRegistrationMenu = true;
    }
  }
};
</script>
