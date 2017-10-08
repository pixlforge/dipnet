<template>
    <div>
        <app-moon-loader :loading="loader.loading"
                         :color="loader.color"
                         :size="loader.size"></app-moon-loader>

        <button class="btn btn-black" @click="resend">Renvoyer</button>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../../mixins';

    export default {
        props: ['data-email'],
        components: {
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {
            resend() {
                this.toggleLoader();

                axios.put('/invitation', { email: this.dataEmail })
                    .then(() => {
                        this.toggleLoader();
                        flash({
                            message: `L'invitation a bien été renvoyée à l'adresse ${this.dataEmail}`,
                            level: 'success'
                        });
                    })
                    .catch(() => {
                        this.toggleLoader();
                    })
            }
        }
    }
</script>