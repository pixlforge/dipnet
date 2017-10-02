<template>
    <div>
        <a class="dropdown-item" role="link" @click.stop="toggleModal">
            <i class="fa fa-pencil"></i>
            <span class="ml-3">Modifier</span>
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click.stop="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="updateContact">
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
                                    <span class="required">*</span>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control"
                                           v-model.trim="contact.name"
                                           required autofocus>
                                    <div class="help-block" v-if="errors.name" v-text="errors.name[0]"></div>
                                </div>

                                <!--Address line 1-->
                                <div class="form-group my-5">
                                    <label for="address_line1">Adresse ligne 1</label>
                                    <span class="required">*</span>
                                    <input type="text"
                                           id="address_line1"
                                           name="address_line1"
                                           class="form-control"
                                           v-model.trim="contact.address_line1"
                                           required>
                                    <div class="help-block" v-if="errors.address_line1" v-text="errors.address_line1[0]"></div>
                                </div>

                                <!--Address line 2-->
                                <div class="form-group my-5">
                                    <label for="address_line2">Adresse ligne 2</label>
                                    <input type="text"
                                           id="address_line2"
                                           name="address_line2"
                                           class="form-control"
                                           v-model.trim="contact.address_line2">
                                    <div class="help-block" v-if="errors.address_line2" v-text="errors.address_line2[0]"></div>
                                </div>

                                <!--Zip-->
                                <div class="form-group my-5">
                                    <label for="zip">Code postal</label>
                                    <span class="required">*</span>
                                    <input type="text"
                                           id="zip"
                                           name="zip"
                                           class="form-control"
                                           v-model.trim="contact.zip"
                                           required>
                                    <div class="help-block" v-if="errors.zip" v-text="errors.zip[0]"></div>
                                </div>

                                <!--City-->
                                <div class="form-group my-5">
                                    <label for="city">Ville</label>
                                    <span class="required">*</span>
                                    <input type="text"
                                           id="city"
                                           name="city"
                                           class="form-control"
                                           v-model.trim="contact.city"
                                           required>
                                    <div class="help-block" v-if="errors.city" v-text="errors.city[0]"></div>
                                </div>

                                <!--Phone-->
                                <div class="form-group my-5">
                                    <label for="phone_number">Téléphone</label>
                                    <input type="text"
                                           id="phone_number"
                                           name="phone_number"
                                           class="form-control"
                                           v-model.trim="contact.phone_number">
                                    <div class="help-block" v-if="errors.phone_number" v-text="errors.phone_number[0]"></div>
                                </div>

                                <!--Fax-->
                                <div class="form-group my-5">
                                    <label for="fax">Fax</label>
                                    <input type="text"
                                           id="fax"
                                           name="fax"
                                           class="form-control"
                                           v-model.trim="contact.fax">
                                    <div class="help-block" v-if="errors.fax" v-text="errors.fax[0]"></div>
                                </div>

                                <!--Email-->
                                <div class="form-group my-5">
                                    <label for="email">E-mail</label>
                                    <span class="required">*</span>
                                    <input type="text"
                                           id="email"
                                           name="email"
                                           class="form-control"
                                           v-model.trim="contact.email"
                                           required>
                                    <div class="help-block" v-if="errors.email" v-text="errors.email[0]"></div>
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
                                                @click.prevent="updateContact">
                                            Mettre à jour
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <app-moon-loader :loading="loader.loading" :color="loader.color" :size="loader.size">
                </app-moon-loader>
            </div>
        </transition>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../../app';
    import mixins from '../../mixins';

    export default {
        props: ['data'],
        data() {
            return {
                contact: {
                    id: this.data.id,
                    name: this.data.name,
                    address_line1: this.data.address_line1,
                    address_line2: this.data.address_line2,
                    zip: this.data.zip,
                    city: this.data.city,
                    phone_number: this.data.phone_number,
                    fax: this.data.fax,
                    email: this.data.email,
                    company_id: this.data.company_id
                },
                errors: {}
            };
        },
        components: {
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {
            updateContact() {
                this.toggleLoader();

                axios.put('/contacts/' + this.contact.id, this.contact)
                    .then(() => {
                        eventBus.$emit('contactWasUpdated', this.contact);
                    })
                    .then(() => {
                        this.toggleLoader();
                        this.toggleModal();
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data;
                    });
            }
        }
    }
</script>