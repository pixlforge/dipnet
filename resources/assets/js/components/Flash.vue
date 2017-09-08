<template>
    <div class="alert alert-flash z-depth-1"
         :class="alertClass"
         role="alert"
         v-show="show"
         v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message', 'level'],
        data() {
            return {
                body: this.message,
                show: false
            }
        },
        created() {
            if (this.message) {
                this.flash();
            }
            window.events.$on('flash', data => this.flash(data));
        },
        computed: {
            alertClass() {
                return 'alert-' + this.level;
            }
        },
        methods: {
            flash(data) {
                if (data) {
                    this.body = data.message;
                    this.level = data.level;
                }

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
        z-index: 99;
        position: fixed;
        top: 30px;
        right: 35px;
    }
</style>