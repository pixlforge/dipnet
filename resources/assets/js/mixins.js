import moment from "moment";

export default {
  data() {
    return {
      loader: {
        color: '#fff',
        size: '96px'
      },
      showModal: false,
      appName: window.Laravel.appName,
      momentFormat: 'LLL',
      momentLocale: 'fr'
    }
  },
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
    /**
     * Routes
     */
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
  filters: {
    capitalize(value) {
      if (!value) return ''

      value = value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1)
    }
  },
  methods: {
    getDate(date) {
      return moment(date)
        .locale(this.momentLocale)
        .format(this.momentFormat);
    },
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
    toggleModal() {
      this.showModal = !this.showModal
      document.getElementById('body').classList.toggle('modal__open')
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