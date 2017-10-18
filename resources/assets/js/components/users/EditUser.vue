<template>
    <div>

        <!--Button-->
        <a class="dropdown-item" role="button" @click.stop="toggleModal">
            <i class="fal fa-pencil"></i>
            <span class="ml-3">Modifier</span>
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="updateUser">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Modifier l'utilisateur</h3>

                            <!--Form-->
                            <form @submit.prevent>

                                <!--Username-->
                                <div class="form-group">
                                    <label for="username">Nom d'utilisateur</label>
                                    <span class="required">*</span>
                                    <input role="text"
                                           id="username"
                                           name="username"
                                           class="form-control"
                                           v-model.trim="user.username"
                                           required autofocus>
                                    <div class="help-block" v-if="errors.username" v-text="errors.username[0]"></div>
                                </div>

                                <!--Email-->
                                <div class="form-group my-5">
                                    <label for="email">Email</label>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           class="form-control"
                                           v-model.trim="user.email">
                                    <div class="help-block" v-if="errors.email" v-text="errors.email[0]"></div>
                                </div>

                                <!--Role-->
                                <div class="form-group my-5">
                                    <label for="role">Rôle</label>
                                    <select name="role"
                                            id="role"
                                            class="form-control custom-select"
                                            v-model.trim="user.role">
                                        <option disabled>Sélectionnez un rôle</option>
                                        <option value="utilisateur">Utilisateur</option>
                                        <option value="administrateur">Administrateur</option>
                                    </select>
                                </div>

                                <!--Company-->
                                <div class="form-group my-5">
                                    <label for="company_id">Société</label>
                                    <select name="company_id"
                                            id="company_id"
                                            class="form-control custom-select"
                                            v-model.trim="user.company_id">
                                        <option disabled>Sélectionnez une société</option>
                                        <option v-for="company in companies" :value="company.id" v-text="company.name"></option>
                                    </select>
                                </div>

                                <!--Buttons-->
                                <div class="form-group d-flex flex-column flex-lg-row my-6">
                                    <div class="col-12 col-lg-5 px-0 pr-lg-2">
                                        <button class="btn btn-block btn-lg btn-white"
                                                @click.stop="toggleModal">
                                            <i class="fal fa-times mr-2"></i>
                                            Annuler
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-7 px-0 pl-lg-2">
                                        <button class="btn btn-block btn-lg btn-black"
                                                @click.prevent="updateUser">
                                            <i class="fal fa-check mr-2"></i>
                                            Modifier
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <app-moon-loader :loading="loader.loading"
                                 :color="loader.color"
                                 :size="loader.size"></app-moon-loader>
            </div>
        </transition>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../../app';
    import mixins from '../../mixins';

    export default {
        props: [
            'data-user',
            'data-companies'
        ],
        data() {
            return {
                user: this.dataUser,
                companies: this.dataCompanies,
                errors: {}
            };
        },
        mixins: [mixins],
        components: {
            'app-moon-loader': MoonLoader
        },
        methods: {
            updateUser() {
                this.toggleLoader();

                axios.put('/users/' + this.user.id, this.user)
                    .then(() => {
                        eventBus.$emit('userWasUpdated', this.user);
                    })
                    .then(() => {
                        this.toggleLoader();
                        this.toggleModal();
                    })
                    .catch((error) => {
                        this.toggleLoader();
                        if (error.response.status === 422) {
                            flash({
                                message: "Erreur. La validation a échoué.",
                                level: 'danger'
                            });

                            return;
                        }
                        flash({
                            message: "Erreur. Veuillez réessayer plus tard.",
                            level: 'danger'
                        });
                    })
            }
        }
    }
</script>