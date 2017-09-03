<template>
    <div class="col-xs-12 col-lg-6 vh-100 d-flex align-items-center">
        <div class="col-xs-12 col-lg-8 offset-lg-2">

            <!--Loader-->
            <moon-loader :loading="loader.loading"
                         :color="loader.color"
                         :size="loader.size"></moon-loader>

            <form action="/register"
                  role="form"
                  v-if="showAccountForm"
                  @keydown="form.errors.clear($event.target.name)">

                <h4 class="text-center">Enregistrement</h4>

                <!--Username-->
                <div class="form-group my-5">
                    <label for="username">Nom d'utilisateur</label>
                    <span class="required">requis</span>
                    <input type="text"
                           id="username"
                           name="username"
                           v-model="form.username"
                           class="form-control"
                           placeholder="e.g. John Doe"
                           required autofocus>
                </div>

                <!--Email-->
                <div class="form-group my-5">
                    <label for="email">E-mail</label>
                    <span class="required">requis</span>
                    <input type="email"
                           id="email"
                           name="email"
                           v-model="form.email"
                           class="form-control"
                           placeholder="e.g. votre@email.ch"
                           required>
                </div>

                <!--Password-->
                <div class="form-group my-5">
                    <label for="password">Mot de passe</label>
                    <span class="required">requis</span>
                    <input type="password"
                           id="password"
                           name="password"
                           v-model="form.password"
                           class="form-control"
                           placeholder="Entre 6 et 45 caractères"
                           required>
                </div>

                <!--Password confirm-->
                <div class="form-group my-5">
                    <label for="password-confirm">Confirmation du mot de passe</label>
                    <span class="required">requis</span>
                    <input type="password"
                           id="password-confirm"
                           name="password_confirmation"
                           v-model="form.password_confirmation"
                           class="form-control"
                           placeholder="Répétez votre mot de passe"
                           required>
                </div>
                <button class="btn btn-black btn-block mt-5" @click.prevent="onSubmit">
                    Créer le compte
                </button>
                <p class="text-small text-center mt-4">
                    Vous disposez déjà d'un compte?
                    <a href="/login" class="ml-3">Connectez-vous</a>
                </p>
            </form>
        </div>
    </div>
</template>

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
                showAccountForm: true,
                showContactForm: false,
                showCompanyForm: false,
                loader: {
                    color: '#fff',
                    size: '96px',
                    loading: false
                }
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