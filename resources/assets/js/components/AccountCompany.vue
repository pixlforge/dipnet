<template>
    <div class="container-fluid">
        <div class="row">

            <a href="/">
                <div class="company-logo-container" :class="logoWhite" aria-hidden="true"></div>
            </a>

            <div class="col-12 col-lg-6 fixed-lg-left bg-shapes-red no-padding">
                <div class="col-12 col-md-5 offset-md-5 mt-md-checklist no-padding">

                    <!--Loader-->
                    <app-moon-loader :loading="loader.loading"
                                     :color="loader.color"
                                     :size="loader.size"></app-moon-loader>

                    <div class="d-flex flex-column justify-content-center checklist">
                        <a class="d-flex align-items-center checklist-item checklist-item-done link-unstyled">
                            <span class="badge badge-white mx-4"><i class="fa fa-check"></i></span>
                            <span>Enregistrement</span>
                        </a>
                        <a class="d-flex align-items-center checklist-item checklist-item-done link-unstyled">
                            <span class="badge badge-white mx-4"><i class="fa fa-check"></i></span>
                            <span>Contact</span>
                        </a>
                        <a class="d-flex align-items-center checklist-item checklist-item-active link-unstyled">
                            <span class="badge badge-white mx-4">3</span>
                            <span>Société</span>
                        </a>
                        <a class="d-flex align-items-center checklist-item link-unstyled">
                            <span class="badge badge-white mx-4">4</span>
                            <span>Prêt</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 push-lg-6 vh-100 d-flex align-items-center">
                <div class="col-12 col-lg-8 mx-auto py-5">

                    <!--Company Info Form-->
                    <form role="form"
                          @submit.prevent>

                        <h4 class="text-center">Société</h4>

                        <!--Name-->
                        <div class="form-group my-5">
                            <label for="name">Nom</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   v-model="company.name"
                                   class="form-control"
                                   placeholder="e.g. Pantone SA"
                                   autofocus>
                            <div class="help-block"
                                 v-if="errors.name"
                                 v-text="errors.name[0]"></div>
                        </div>

                        <button class="btn btn-black btn-block mt-5"
                                @click="updateWithCompany">
                            Mettre à jour
                        </button>

                        <p class="mt-5 text-center"><small>Veuillez ne pas remplir le champ-ci dessus dans le cas où vous ne faîtes pas partie d'une société et commandez en votre nom propre</small></p>

                        <p class="text-small text-center mt-5">
                            <a @click="updateAsSelf">
                                Passer cette étape
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';

    export default {
        data() {
            return {
                company: {
                    name: ''
                },
                errors: {},
                loader: {
                    color: '#fff',
                    size: '96px',
                    loading: false
                },
                appName: Laravel.appName
            };
        },
        components: {
            'app-moon-loader': MoonLoader
        },
        computed: {
            logoWhite() {
                return this.appName === 'Dipnet' ? 'company-logo-dip-white' : 'company-logo-multicop-white';
            }
        },
        methods: {
//            update() {
//                this.toggleLoader();
//
//                if (this.company.name.length === 0) {
//                    this.updateAsSelf();
//                } else {
//                    this.updateWithCompany();
//                }
//            },
            updateWithCompany() {
                this.updateCompany(this.company);
            },
            updateAsSelf() {
                this.company.name = 'self';
                this.updateCompany(this.company);
            },
            updateCompany(company) {
                this.toggleLoader();

                axios.put('/register/company', company)
                    .then(() => {
                        this.toggleLoader();
                        this.company = {};
                        this.errors = {};
                        flash({
                            message: 'Félicitations! Votre compte a bien été mis à jour!',
                            level: 'success'
                        });
                        setTimeout(() => {
                            window.location.pathname = '/';
                        }, 2500);
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data.errors;
                    });
            },
            toggleLoader() {
                this.loader.loading = !this.loader.loading;
            }
        }
    }
</script>

<style scoped>
    .help-block {
        position: relative;
    }

    a {
        cursor: pointer;
    }

    .company-logo-container {
        position: fixed;
    }
</style>