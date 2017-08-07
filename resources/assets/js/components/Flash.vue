<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        <strong>OK!</strong>
        <span class="ml-3">{{ body }}</span>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: '',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
                this.flash(message)
            });
        },

        destroyed() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
                this.flash(message)
            });
        },

        methods: {
            flash(message) {
                this.body = message;
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3500);
            }
        }

    }
</script>

<style>
    .alert-flash {
        position: fixed;
        top: 30px;
        right: 35px;
    }
</style>