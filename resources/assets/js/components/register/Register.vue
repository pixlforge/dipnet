<template>
  <div>
    <transition
      name="fade"
      mode="out-in">
      <register-menu
        v-if="showRegistrationMenu"
        :app-name="appName"
        @registrationSelection="selection"/>
      <register-join-infos
        v-if="showJoinInfos"
        @backToMenu="backToMenu"/>
      <register-account
        v-if="showAccountForm"
        :registration-type="registrationType"
        :invitation="invitation"
        @accountCreated="accountCreated"/>
      <register-contact
        v-if="showContactForm"
        :registration-type="registrationType"
        :invitation="invitation"
        @contactCreated="contactCreated"/>
      <register-company
        v-if="showCompanyForm"
        @companyCreated="companyCreated"/>
    </transition>
    <moon-loader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import RegisterMenu from "./RegisterMenu.vue";
import RegisterJoinInfos from "./RegisterJoinInfos.vue";
import RegisterAccount from "./RegisterAccount.vue";
import RegisterContact from "./RegisterContact.vue";
import RegisterCompany from "./RegisterCompany.vue";
import mixins from "../../mixins";
import { mapGetters } from "vuex";

export default {
  components: {
    MoonLoader,
    RegisterMenu,
    RegisterJoinInfos,
    RegisterAccount,
    RegisterContact,
    RegisterCompany
  },
  mixins: [mixins],
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
  created() {
    /**
     * Get the invitation token and try to confirm it.
     */
    if (this.token) {
      this.registrationType = "join";
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("invitation.confirm"), {
          token: this.token
        })
        .then(response => {
          this.invitation = response.data;
          this.showAccountForm = true;
          this.$store.dispatch("toggleLoader");
        })
        .catch(() => {
          this.$store.dispatch("toggleLoader");
        });
    } else {
      this.showRegistrationMenu = true;
    }
  },
  methods: {
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
