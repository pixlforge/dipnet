export default {
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
        }
    }
}