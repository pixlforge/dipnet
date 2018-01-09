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
    logo() {
      return this.appName === 'Dipnet' ? 'company-logo-dip' : 'company-logo-multicop'
    },
    logoWhite() {
      return this.appName === 'Dipnet' ? 'company-logo-dip-white' : 'company-logo-multicop-white'
    },

    /**
     * Routes
     */
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
      this.showModal === false ? this.showModal = true : this.showModal = false
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