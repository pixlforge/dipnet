<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';

    export default {

        data() {
            return {
                form: new Form({
                    address_line1: '',
                    address_line2: '',
                    zip: '',
                    city: '',
                    phone_number: '',
                    fax: ''
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

                this.form.post('/profile/details/contact')
                    .then(response => {
                        this.loading = false;
                        window.location.href = '/profile/details/company';
                    })
                    .catch(error=> {
                        this.loading = false;
                    });
            }
        }
    }
</script>