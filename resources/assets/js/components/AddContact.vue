<template>
    <div>

        <!--Button-->
        <a @click="toggleModal" class="btn btn-lg btn-black mt-5">
            Nouveau contact
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <!--Title-->
                            <h3 class="m-5">Nouveau contact</h3>

                            <!--Form-->
                            <form method="POST" action="">

                                <!--Name-->
                                <div class="form-group ml-5 mr-8">
                                    <label for="name">Nom</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="name" name="name" v-model="form.name" class="form-control" placeholder="e.g. Principal">
                                    <div class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
                                </div>

                                <!--Address line 1-->
                                <div class="form-group my-5 ml-5 mr-8">
                                    <label for="address_line1">Adresse ligne 1</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="address_line1" name="address_line1" v-model="form.address_line1" class="form-control" placeholder="e.g. Rue, n°">
                                    <div class="help-block" v-if="form.errors.has('address_line1')" v-text="form.errors.get('address_line1')"></div>
                                </div>

                                <!--Address line 2-->
                                <div class="form-group my-5 ml-5 mr-8">
                                    <label for="address_line2">Adresse ligne 2</label>
                                    <input type="text" id="address_line2" name="address_line2" v-model="form.address_line2" class="form-control" placeholder="e.g. Appartement, suite">
                                    <div class="help-block" v-if="form.errors.has('address_line2')" v-text="form.errors.get('address_line2')"></div>
                                </div>

                                <!--Zip-->
                                <div class="form-group my-5 ml-5 mr-8">
                                    <label for="zip">NPA</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="zip" name="zip" v-model="form.zip" class="form-control" placeholder="e.g. 1002">
                                    <div class="help-block" v-if="form.errors.has('zip')" v-text="form.errors.get('zip')"></div>
                                </div>

                                <!--City-->
                                <div class="form-group my-5 ml-5 mr-8">
                                    <label for="city">Ville</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="city" name="city" v-model="form.city" class="form-control" placeholder="e.g. Lausanne">
                                    <div class="help-block" v-if="form.errors.has('city')" v-text="form.errors.get('city')"></div>
                                </div>

                                <!--Phone-->
                                <div class="form-group my-5 ml-5 mr-8">
                                    <label for="phone_number">Téléphone</label>
                                    <input type="text" id="phone_number" name="phone_number" v-model="form.phone_number" class="form-control" placeholder="e.g. +41 (0)12 345 67 89">
                                    <div class="help-block" v-if="form.errors.has('phone_number')" v-text="form.errors.get('phone_number')"></div>
                                </div>

                                <!--Fax-->
                                <div class="form-group my-5 ml-5 mr-8">
                                    <label for="fax">Fax</label>
                                    <input type="text" id="fax" name="fax" v-model="form.fax" class="form-control" placeholder="e.g. +41 (0)12 345 67 90">
                                    <div class="help-block" v-if="form.errors.has('fax')" v-text="form.errors.get('fax')"></div>
                                </div>

                                <!--Email-->
                                <div class="form-group my-5 ml-5 mr-8">
                                    <label for="email">E-mail</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="email" name="email" v-model="form.email" class="form-control" placeholder="e.g. votre@email.ch">
                                    <div class="help-block" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></div>
                                </div>

                                <!--Buttons-->
                                <div class="form-group d-flex flex-row my-5 ml-5 mr-8">
                                    <div class="col-5 pl-0">
                                        <button class="btn btn-block btn-white" @click.prevent="toggleModal">
                                            Annuler
                                        </button>
                                    </div>
                                    <div class="col-7 pr-0">
                                        <button class="btn btn-block btn-black" @click.prevent="onSubmit">
                                            Ajouter
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

    export default {

        data() {
            return {
                form: new Form({
                    name: '',
                    address_line1: '',
                    address_line2: '',
                    zip: '',
                    city: '',
                    phone_number: '',
                    fax: '',
                    email: '',
                    company_id: ''
                }),
                color: '#fff',
                size: '96px',
                loading: false,
                showModal: false
            }
        },

        components: {
            MoonLoader
        },

        methods: {
            toggleModal() {
                this.showModal === false ? this.showModal = true : this.showModal = false;
            },

            onSubmit() {
                this.loading = true;

                this.form.post('/contacts')
                    .then(response => {
                        this.loading = false;
                    })
                    .then(response => {
                        this.showModal = false;
                    })
                    .catch(response => {
                        this.loading = false;
                    });
            }
        }
    }
</script>