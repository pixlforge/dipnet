export default {
    data() {
        return {
            loader: {
                color: '#fff',
                size: '96px',
                loading: false
            },
        };
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
        }
    }
}