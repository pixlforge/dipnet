<template>
    <div>
        <a class="dropdown-item" role="button" @click.stop="toggleModal">
            <i class="fa fa-pencil"></i>
            <span class="ml-3">Modifier</span>
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click.stop="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="editContact">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Modifier un contact</h3>

                            <!--Form-->
                            <form @submit.prevent>

                                <!--Name-->
                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <span class="required">requis</span>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control"
                                           placeholder="e.g. Principal"
                                           v-model.trim="form.name"
                                           required autofocus>
                                    <div class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
                                </div>

                                <!--Address line 1-->
                                <div class="form-group my-5">
                                    <label for="address_line1">Adresse ligne 1</label>
                                    <span class="required">requis</span>
                                    <input type="text"
                                           id="address_line1"
                                           name="address_line1"
                                           class="form-control"
                                           placeholder="e.g. Rue, n°"
                                           v-model.trim="form.address_line1"
                                           required>
                                    <div class="help-block" v-if="form.errors.has('address_line1')" v-text="form.errors.get('address_line1')"></div>
                                </div>

                                <!--Address line 2-->
                                <div class="form-group my-5">
                                    <label for="address_line2">Adresse ligne 2</label>
                                    <input type="text"
                                           id="address_line2"
                                           name="address_line2"
                                           class="form-control"
                                           placeholder="e.g. Appartement, suite"
                                           v-model.trim="form.address_line2">
                                    <div class="help-block" v-if="form.errors.has('address_line2')" v-text="form.errors.get('address_line2')"></div>
                                </div>

                                <!--Zip-->
                                <div class="form-group my-5">
                                    <label for="zip">Code postal</label>
                                    <span class="required">requis</span>
                                    <input type="text"
                                           id="zip"
                                           name="zip"
                                           class="form-control"
                                           placeholder="e.g. 1002"
                                           v-model.trim="form.zip"
                                           required>
                                    <div class="help-block" v-if="form.errors.has('zip')" v-text="form.errors.get('zip')"></div>
                                </div>

                                <!--City-->
                                <div class="form-group my-5">
                                    <label for="city">Ville</label>
                                    <span class="required">requis</span>
                                    <input type="text"
                                           id="city"
                                           name="city"
                                           class="form-control"
                                           placeholder="e.g. Lausanne"
                                           v-model.trim="form.city"
                                           required>
                                    <div class="help-block" v-if="form.errors.has('city')" v-text="form.errors.get('city')"></div>
                                </div>

                                <!--Phone-->
                                <div class="form-group my-5">
                                    <label for="phone_number">Téléphone</label>
                                    <input type="text"
                                           id="phone_number"
                                           name="phone_number"
                                           class="form-control"
                                           placeholder="e.g. +41 (0)12 345 67 89"
                                           v-model.trim="form.phone_number">
                                    <div class="help-block" v-if="form.errors.has('phone_number')" v-text="form.errors.get('phone_number')"></div>
                                </div>

                                <!--Fax-->
                                <div class="form-group my-5">
                                    <label for="fax">Fax</label>
                                    <input type="text"
                                           id="fax"
                                           name="fax"
                                           class="form-control"
                                           placeholder="e.g. +41 (0)12 345 67 90"
                                           v-model.trim="form.fax">
                                    <div class="help-block" v-if="form.errors.has('fax')" v-text="form.errors.get('fax')"></div>
                                </div>

                                <!--Email-->
                                <div class="form-group my-5">
                                    <label for="email">E-mail</label>
                                    <span class="required">requis</span>
                                    <input type="text"
                                           id="email"
                                           name="email"
                                           class="form-control"
                                           placeholder="e.g. votre@email.ch"
                                           v-model.trim="form.email"
                                           required>
                                    <div class="help-block" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></div>
                                </div>

                                <!--Buttons-->
                                <div class="form-group d-flex flex-column flex-lg-row my-6">
                                    <div class="col-12 col-lg-5 px-0 pr-lg-2">
                                        <button class="btn btn-block btn-lg btn-white"
                                                @click.stop="toggleModal">
                                            Annuler
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-7 px-0 pl-lg-2">
                                        <button class="btn btn-block btn-lg btn-black"
                                                @click.prevent="editContact">
                                            Mettre à jour
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>
            </div>
        </transition>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import { eventBus } from '../app';

    export default {
        props: ['data'],
        data() {
            return {
                form: new Form({
                    name: this.data.name,
                    address_line1: this.data.address_line1,
                    address_line2: this.data.address_line2,
                    zip: this.data.zip,
                    city: this.data.city,
                    phone_number: this.data.phone_number,
                    fax: this.data.fax,
                    email: this.data.email,
                    company_id: this.data.company_id
                }),
                contact: this.data,
                color: '#fff',
                size: '96px',
                loading: false,
                showModal: false
            };
        },
        components: { MoonLoader },
        methods: {
            toggleModal() {
                this.showModal === false ? this.showModal = true : this.showModal = false;
            },

            editContact() {
                this.loading = true;

                this.form.put('/contacts/' + this.contact.id)
                    .then(() => {
                        eventBus.$emit('contactWasUpdated', this.contact);
                    })
                    .then(() => {
                        this.loading = false;
                        this.showModal = false;
                    })
                    .catch(this.loading = false);
            }
        }
    }
</script>