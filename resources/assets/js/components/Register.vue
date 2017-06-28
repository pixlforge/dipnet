<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';

    export default {

        data() {
            return {
                form: new Form({
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
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
                    })
                    .then(response => {
                        window.location.href = '/';
                    })
                    .catch(response => {
                        this.loading = false;
                    });
            }
        }
    }
</script>