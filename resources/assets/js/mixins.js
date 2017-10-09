export default {
    data() {
        return {
            loader: {
                color: '#fff',
                size: '96px',
                loading: false
            },
            showModal: false,
            appName: Laravel.appName,
            momentFormat: 'LLL',
            momentLocale: 'fr'
        };
    },
    computed: {
        logo() {
            return this.appName === 'Dipnet' ? 'company-logo-dip' : 'company-logo-multicop';
        },
        logoWhite() {
            return this.appName === 'Dipnet' ? 'company-logo-dip-white' : 'company-logo-multicop-white';
        }
    },
    methods: {
        redirectIfNotConfirmed(error) {
            if (error.response.status === 403) {
                flash({
                    message: "Vous devez d'abord confirmer votre adresse e-mail.",
                    level: 'danger'
                });
                setTimeout(function () {
                    window.location.pathname = '/profile';
                }, 2500);
            }
        },
        toggleLoader() {
            this.loader.loading = !this.loader.loading;
        },
        toggleModal() {
            this.showModal === false ? this.showModal = true : this.showModal = false;
        },
        finishRegistration() {
            this.congratulateUponRegistration();
            this.redirectUser();
        },
        congratulateUponRegistration() {
            flash({
                message: 'Félicitations! Votre compte est fin prêt!',
                level: 'success'
            });
        },
        redirectUser() {
            setTimeout(() => {
                window.location = '/';
            }, 2500);
        }
    }
}