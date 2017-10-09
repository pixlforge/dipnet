<template>
    <div class="mt-4 mr-3">
        <a class="btn btn-lg btn-orange" @click="sendConfirmationAgain">
            <i class="fal fa-redo mr-2"></i>
            Renvoyer l'email de confirmation
        </a>

        <app-moon-loader :loading="loader.loading"
                         :color="loader.color"
                         :size="loader.size"></app-moon-loader>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../../mixins';

    export default {
        components: {
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {
            sendConfirmationAgain() {
                this.toggleLoader();

                axios.put('/register/send-again')
                    .then(() => {
                        this.toggleLoader();
                        flash({
                            message: "L'email de confirmation vous a été envoyé à nouveau.",
                            level: 'success'
                        });
                    })
                    .catch(() => {
                        this.toggleLoader();
                        flash({
                            message: "Il y a eu un problème avec le renvoi de l'email de confirmation",
                            level: 'danger'
                        });
                    });
            }
        }
    }
</script>