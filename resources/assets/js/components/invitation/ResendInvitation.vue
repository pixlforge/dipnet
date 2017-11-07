<template>
    <div>

        <!--Loader-->
        <app-moon-loader :loading="loader.loading"
                         :color="loader.color"
                         :size="loader.size">
        </app-moon-loader>

        <button class="btn btn-black" @click="resend">
            <i class="fal fa-redo mr-2"></i>
            Renvoyer
        </button>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
    import mixins from '../../mixins'

    export default {
        props: ['data-invitation'],
        data() {
            return {
                invitation: this.dataInvitation
            }
        },
        components: {
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {

            /**
             * Resend an existing invitation.
             */
            resend() {
                this.toggleLoader()

                axios.put('/invitation', this.invitation)
                    .then(() => {
                        this.toggleLoader()
                        flash({
                            message: `L'invitation a bien été renvoyée à l'adresse ${this.invitation.email}`,
                            level: 'success'
                        })
                    })
                    .catch(() => {
                        this.toggleLoader()
                    })
            }
        }
    }
</script>
