<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';

    export default {

        data() {
            return {
                form: new Form({
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }),
                color: '#fff',
                size: '96px',
                loading: false
            }
        },

        components: {
            MoonLoader
        },

        methods: {

            onSubmit() {
                this.loading = true;

                this.form.post('/register')
                    .then(response => {
                        this.loading = false;
                        window.location.href = 'profile/details/contact';
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            }
        }
    }
</script>