import moment from "moment";

export const modelCount = {
  computed: {
    modelCount() {
      if (this.meta.total > 1) {
        return this.meta.total + ' ' + this.modelNamePlural
      } else if (this.meta.total === 1) {
        return this.meta.total + ' ' + this.modelNameSingular
      } else {
        if (this.modelGender === 'M') {
          return 'Aucun ' + this.modelNameSingular
        } else if (this.modelGender === 'F') {
          return 'Aucune ' + this.modelNameSingular
        }
      }
    },
  },
};

export const appName = {
  data() {
    return {
      appName: window.Laravel.appName,
    };
  },
};

export const logo = {
  computed: {
    logoColor() {
      if (this.appName === 'Dipnet') {
        return '/img/logos/dip-logo-md.png'
      } else if (this.appName === 'Multicop') {
        return '/img/logos/multicop-logo-md.png'
      }
    },
    logoBw() {
      if (this.appName === 'Dipnet') {
        return '/img/logos/dip-logo-white-md.png'
      } else if (this.appName === 'Multicop') {
        return '/img/logos/multicop-logo-white-md.png'
      }
    },
  }
};

export const filters = {
  filters: {
    capitalize(value) {
      if (!value) return ''
      value = value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1)
    }
  },
};

export const loader = {
  data() {
    return {
      loader: {
        color: '#fff',
        size: '96px'
      },
    }
  },
};

export const dates = {
  data() {
    return {
      momentFormat: 'LLL',
      momentLocale: 'fr'
    };
  },
  methods: {
    getDate(date) {
      return moment(date)
        .locale(this.momentLocale)
        .format(this.momentFormat);
    },
  }
};

export const modal = {
  data() {
    return {
      showModal: false,
    }
  },
  methods: {
    toggleModal() {
      this.showModal = !this.showModal
      document.getElementById('body').classList.toggle('modal__open')
    },
  }
};

export const panels = {
  data() {
    return {
      modelToEdit: {},
      showAddPanel: false,
      showEditPanel: false,
    };
  },
  mounted() {
    this.bindEscapeKey();
  },
  methods: {
    openAddPanel() {
      this.showAddPanel = true;
      this.toggleModal();
    },
    openEditPanel(model) {
      this.modelToEdit = model;
      this.showEditPanel = true;
      this.toggleModal();
    },
    closePanels() {
      this.showAddPanel = false;
      this.showEditPanel = false;
      this.toggleModal();
    },
    bindEscapeKey() {
      const escapeHandler = event => {
        if (event.key === "Escape" && (this.showAddPanel || this.showEditPanel)) {
          this.showAddPanel = false;
          this.showEditPanel = false;
          this.toggleModal();
        }
      };
      document.addEventListener("keydown", escapeHandler);

      this.$once("hook:destroyed", () => {
        document.removeEventListener("keydown", escapeHandler);
      });
    }
  }
};

export const registration = {
  computed: {
    loginRoute() {
      return window.route('login')
    },
    forgottenRoute() {
      return window.route('password.request')
    },
    registerRoute() {
      return window.route('register.index')
    },
  },
  methods: {
    redirectIfNotConfirmed(error) {
      if (error.response.status === 403) {
        window.flash({
          message: "Vous devez d'abord confirmer votre adresse e-mail.",
          level: 'danger'
        })
        setTimeout(function () {
          window.location.pathname = '/profile'
        }, 2500)
      }
    },
    finishRegistration() {
      this.congratulateUponRegistration()
      this.redirectUser()
    },
    congratulateUponRegistration() {
      window.flash({
        message: 'Félicitations! Votre compte est fin prêt!',
        level: 'success'
      })
    },
    redirectUser() {
      setTimeout(() => {
        window.location = '/'
      }, 2500)
    }
  }
}