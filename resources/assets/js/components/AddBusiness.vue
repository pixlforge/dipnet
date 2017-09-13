<template>
    <div>

        <!--Button-->
        <a @click="toggleModal" class="btn btn-lg btn-black mt-5" role="button">
            Nouvelle affaire
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal" @keyup.esc.prevent="toggleModal" @keyup.enter="addBusiness">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Nouvelle affaire</h3>

                            <!--Form-->
                            <form @submit.prevent>

                                <!--Name-->
                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <span class="required">*</span>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control"
                                           v-model.trim="business.name"
                                           required autofocus>
                                    <div class="help-block" v-if="errors.name" v-text="errors.name[0]"></div>
                                </div>
                                
                                <!--Status-->
                                <div class="form-group my-5">
                                    <label for="status">Statut</label>
                                    <select name="status"
                                            id="status"
                                            class="form-control custom-select"
                                            v-model.trim="business.status">
                                        <option disabled>Sélectionnez un statut</option>
                                        <option value="temporaire">Temporaire</option>
                                        <option value="permanent">Permanent</option>
                                    </select>
                                </div>

                                <!--Description-->
                                <div class="form-group my-5">
                                    <label for="description">Description</label>
                                    <input type="text"
                                           id="description"
                                           name="description"
                                           class="form-control"
                                           v-model.trim="business.description">
                                    <div class="help-block" v-if="errors.description" v-text="errors.description[0]"></div>
                                </div>

                                <div class="form-group my-5">
                                    <label for="company_id">Société</label>
                                    <select name="company_id"
                                            id="company_id"
                                            class="form-control custom-select"
                                            v-model.trim="business.company_id">
                                        <option disabled>Sélectionnez une société</option>
                                        <option v-for="company in companies">{{ company.name }}</option>
                                    </select>
                                    <div class="help-block" v-if="errors.company_id" v-text="errors.company_id[0]"></div>
                                </div>

                                <div class="form-group my-5">
                                    <label for="contact_id">Contact</label>
                                    <select name="contact_id"
                                            id="contact_id"
                                            class="form-control custom-select"
                                            v-model.number.trim="business.contact_id">
                                        <option disabled>Sélectionnez un contact</option>
                                        <option v-for="contact in contacts">{{ contact.name }}</option>
                                    </select>
                                    <div class="help-block" v-if="errors.contact_id" v-text="errors.contact_id[0]"></div>
                                </div>

                                <!--Buttons-->
                                <div class="form-group d-flex flex-column flex-lg-row my-6">
                                    <div class="col-12 col-lg-5 px-0 pr-lg-2">
                                        <button class="btn btn-block btn-lg btn-white"
                                                @click.prevent.stop="toggleModal">
                                            Annuler
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-7 px-0 pl-lg-2">
                                        <button class="btn btn-block btn-lg btn-black"
                                                @click.prevent="addBusiness">
                                            Ajouter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <app-moon-loader :loading="loader.loading" :color="loader.color" :size="loader.size"></app-moon-loader>
            </div>
        </transition>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../mixins';

    export default {
        props: ['companies'],
        data() {
            return {
                business: {
                    name: '',
                    status: '',
                    description: '',
                    company_id: 0,
                    contact_id: ''
                },
                errors: {}
            }
        },
        components: {
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        mounted() {
            console.log(this.companies[this.business.company_id].contact);
        },
        computed: {
            contacts() {
                return this.companies[this.business.company_id].contact;
            }
        },
        methods: {
            addFormat() {
                this.toggleLoader();

                axios.post('/businesses', this.business)
                    .then(response => {
                        this.business.id = response.data;
                        this.$emit('businessWasCreated', this.business);
                    })
                    .then(() => {
                        this.toggleLoader();
                        this.toggleModal();
                        this.business = {};
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data;
                    });
            }
        }
    }
</script>