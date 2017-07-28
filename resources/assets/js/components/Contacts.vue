<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">

                        <!--Page title-->
                        <h1 class="mt-5">
                            Contacts
                        </h1>

                        <add-contact @contactAdded="fetchContacts"></add-contact>

                    </div>
                </div>
            </div>
        </div>

        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">

                <div class="card card-custom center-on-small-only" v-for="contact in contacts">

                    <div class="col col-lg-1 hidden-md-down">
                        <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
                    </div>

                    <div class="col-12 col-lg-2">

                        <!--Name-->
                        <h5 class="mb-0" v-text="contact.name"></h5>
                    </div>

                    <div class="col-12 col-lg-2">

                        <!--Address line 1-->
                        <div v-if="contact.address_line1">
                            <span class="card-content" v-text="contact.address_line1"></span>
                        </div>

                        <!--Address line 2-->
                        <div v-if="contact.address_line2">
                            <span class="card-content" v-text="contact.address_line2"></span>
                        </div>

                        <!--Zip & City-->
                        <div v-if="contact.zip || contact.city">
                            <span class="card-content" v-if="contact.zip" v-text="contact.zip"></span>
                            <span class="card-content" v-if="contact.city" v-text="contact.city"></span>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3">

                        <!--Phone-->
                        <div v-if="contact.phone_number">
                            <span class="card-content"><em>Tel:</em></span>
                            <span class="card-content" v-text="contact.phone_number"></span>
                        </div>

                        <!--Fax-->
                        <div v-if="contact.fax">
                            <span class="card-content"><em>Fax:</em></span>
                            <span class="card-content" v-text="contact.fax"></span>
                        </div>

                        <!--Email-->
                        <div v-if="contact.email">
                            <span class="card-content"><em>Email:</em></span>
                            <span class="card-content" v-text="contact.email"></span>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3">

                        <!--Company-->
                        <div v-if="contact.company">
                            <span class="card-content"><em>Société:</em></span>
                            <span class="card-content" v-text="contact.company.name"></span>
                        </div>

                        <!--Created at-->
                        <div>
                            <span class="card-content"><em>Créé:</em></span>
                            <span class="card-content ml-1" v-text="createdAt"></span>
                        </div>

                        <!--Modified at-->
                        <div>
                            <span class="card-content"><em>Modifié:</em></span>
                            <span class="card-content ml-1" v-text="updatedAt"></span>
                        </div>

                        <!--Created by-->
                        <div v-if="contact.created_by_username">
                            <span class="card-content"><em>Par:</em></span>
                            <span class="card-content ml-1" v-text="contact.created_by_username"></span>
                        </div>
                    </div>

                    <div class="col-12 col-lg-1 center-on-small-only text-lg-right">
                        <!---->
                        <!--<div class="dropdown">-->
                        <!--<a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"-->
                        <!--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--<i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>-->
                        <!--</a>-->
                        <!--<div class="dropdown-menu dropdown-menu-right"-->
                        <!--aria-labelledby="dropdownMenuLink">-->
                        <!--&lt;!&ndash;@unless ($contact->deleted_at === null)&ndash;&gt;-->
                        <!--<form method="POST"-->
                        <!--action="{{ url("/contacts/{$contact->id}/restore") }}">-->
                        <!--&lt;!&ndash;{{ method_field('PUT') }}&ndash;&gt;-->
                        <!--&lt;!&ndash;{{ csrf_field() }}&ndash;&gt;-->

                        <!--<button class="dropdown-item text-success" type="submit">-->
                        <!--<i class="fa fa-refresh"></i>-->
                        <!--<span class="ml-3">Restaurer</span>-->
                        <!--</button>-->
                        <!--</form>-->
                        <!--@else-->
                        <!--<a class="dropdown-item"-->
                        <!--href="{{ url("/contacts/{$contact->id}/edit") }}">-->
                        <!--<i class="fa fa-pencil"></i>-->
                        <!--<span class="ml-3">Modifier</span>-->
                        <!--</a>-->
                        <!--<form method="POST" action="{{ url("/contacts/{$contact->id}") }}">-->
                        <!--{{ method_field('DELETE') }}-->
                        <!--{{ csrf_field() }}-->
                        <!--<button class="dropdown-item text-danger" type="submit">-->
                        <!--<i class="fa fa-trash"></i>-->
                        <!--<span class="ml-3">Supprimer</span>-->
                        <!--</button>-->
                        <!--</form>-->
                        <!--@endunless-->
                        <!--</div>-->
                        <!--</div>-->
                    </div>

                </div>

                <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>

                <paginator :dataSet="dataSet" @updated="fetchContacts"></paginator>

            </div>
        </div>
    </div>
</template>

<script>
    import AddContact from './AddContact.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import moment from 'moment';

    export default {

        data() {
            return {
                dataSet: false,
                contacts: [],
                format: 'LLL',
                locale: 'fr',
                color: '#fff',
                size: '96px',
                loading: false
            }
        },

        components: {
            AddContact,
            MoonLoader
        },

        mounted() {
            this.fetchContacts();
        },

        computed: {
            createdAt() {
                return moment(this.created_at).locale(this.locale).format(this.format);
            },

            updatedAt() {
                return moment(this.updated_at).locale(this.locale).format(this.format);
            }
        },

        methods: {
            fetchContacts(page = 1) {
                this.loading = true;

                axios.get('/contacts?page=' + page)
                    .then(response => {
                        this.refresh(response);
                    })
                    .catch(response => {
                        this.loading = false;
                    });
            },

            refresh(response) {
                this.dataSet = response.data;
                this.contacts = response.data.data;
                this.loading = false;
            }
        }
    }
</script>