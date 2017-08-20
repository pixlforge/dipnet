<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';

    export default {
        data() {
            return {
                form: new Form({
                    name: ''
                }),
                color: '#fff',
                size: '96px',
                loading: false
            }
        },
        components: { MoonLoader },
        methods: {
            onSubmit() {
                this.loading = true;

                this.form.post('/profile/details/company')
                    .then(response => {
                        this.loading = false;
                        window.location.href = '/';
                    })
                    .catch(this.loading = false);
            }
        }
    }
</script>