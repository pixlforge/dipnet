export default {
  data() {
    return {
      loader: {
        color: '#fff',
        size: '96px'
      },
      showModal: false,
      appName: Laravel.appName,
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
      return route('login')
    },

    forgottenRoute() {
      return route('password.request')
    },

    registerRoute() {
      return route('register.index')
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
    redirectIfNotConfirmed(error) {
      if (error.response.status === 403) {
        flash({
          message: "Vous devez d'abord confirmer votre adresse e-mail.",
          level: 'danger'
        })
        setTimeout(function () {
          window.location.pathname = '/profile'
        }, 2500)
      }
    },
    toggleLoader() {
      this.loader.loading = !this.loader.loading
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
      flash({
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