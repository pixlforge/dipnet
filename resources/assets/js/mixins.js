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
      showAddBusinessPanel: false
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
    openAddBusinessPanel() {
      this.showAddBusinessPanel = true;
      this.toggleModal();
    },
    closePanels() {
      this.showAddPanel = false;
      this.showEditPanel = false;
      this.showAddBusinessPanel = false;
      this.toggleModal();
    },
    bindEscapeKey() {
      const escapeHandler = event => {
        if (event.key === "Escape" && (this.showAddPanel || this.showEditPanel || this.showAddBusinessPanel)) {
          this.showAddPanel = false;
          this.showEditPanel = false;
          this.showAddBusinessPanel = false;
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
        message: 'Félicitations! Votre compte est prêt!',
        level: 'success'
      })
    },
    redirectUser() {
      setTimeout(() => {
        window.location = '/'
      }, 2500)
    }
  }
};

export const datepicker = {
  data() {
    return {
      startTime: {
        time: ""
      },
      endTime: {
        time: ""
      },
      option: {
        type: "min",
        week: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
        month: [
          "Janvier",
          "Février",
          "Mars",
          "Avril",
          "Mai",
          "Juin",
          "Juillet",
          "Août",
          "Septembre",
          "Octobre",
          "Novembre",
          "Décembre"
        ],
        format: "LL [à] HH[h]mm",
        placeholder: "date de livraison",
        inputStyle: {
          display: "inline-block",
          padding: "6px",
          "line-height": "22px",
          "font-size": "24px",
          border: "0 solid #fff",
          "box-shadow": "0 0 0 0 rgba(0, 0, 0, 0.2)",
          background: "#f9f9f9",
          "border-radius": "2px",
          color: "#2b2b2b",
          cursor: "pointer"
        },
        color: {
          header: "#e84949",
          headerText: "#fff"
        },
        buttons: {
          ok: "Ok",
          cancel: "Annuler"
        },
        overlayOpacity: 0.5,
        dismissible: true
      },
      timeoption: {
        type: "min",
        week: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
        month: [
          "Janvier",
          "Février",
          "Mars",
          "Avril",
          "Mai",
          "Juin",
          "Juillet",
          "Août",
          "Septembre",
          "Octobre",
          "Novembre",
          "Décembre"
        ],
        format: "LL HH:mm"
      },
      limit: [{ type: "weekday", available: [1, 2, 3, 4, 5] }]
    };
  },
  methods: {
    formatDeliveryDate(date) {
      this.currentDelivery.to_deliver_at = moment(date, "LL HH:mm").format("YYYY-MM-DD HH:mm:ss");
      this.deliveryDateString = moment(date, "LL HH:mm").format("LL [à] HH[h]mm");
      this.update();
    },
    getSelectedDeliveryDate() {
      if (this.delivery.to_deliver_at) {
        this.option.placeholder = moment(this.delivery.to_deliver_at).format(
          "LL [à] HH[h]mm"
        );
        this.deliveryDateString = this.option.placeholder;
      }
    }
  }
};