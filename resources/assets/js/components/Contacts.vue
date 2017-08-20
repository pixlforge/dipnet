<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <h1 class="mt-5">Contacts</h1>
                        <span class="mt-5">
                            {{ dataSet.total }}
                            {{ dataSet.total == 0 || dataSet.total == 1 ? 'résultat' : 'résultats' }}
                        </span>
                        <app-add-contact @contactWasCreated="contactAdded"></app-add-contact>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">
                <app-paginator :dataSet="dataSet" @updated="fetchContacts" class=""></app-paginator>
                <transition-group name="highlight">
                    <app-contact class="card card-custom center-on-small-only"
                         v-for="(contact, index) in contacts"
                         :data="contact"
                         :key="contact.id"
                         @deleted="remove(index)"></app-contact>
                </transition-group>
                <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>
                <app-paginator :dataSet="dataSet" @updated="fetchContacts" class="mt-4"></app-paginator>
            </div>
        </div>
    </div>
</template>

<script>
    import Contact from './Contact.vue';
    import AddContact from './AddContact.vue';
    import Paginator from './Paginator.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../app';

    export default {
        props: ['data'],
        data() {
            return {
                dataSet: this.data,
                contacts: this.data.data,
                color: '#fff',
                size: '96px',
                loading: false
            }
        },
        components: {
            'app-contact': Contact,
            'app-add-contact': AddContact,
            'app-paginator': Paginator,
            MoonLoader
        },
        created() {
            eventBus.$on('contactWasUpdated', (data) => {
                this.edit(data);
            })
        },
        methods: {
            fetchContacts(page = 1) {
                this.loading = true;

                axios.get('/contacts?page=' + page)
                    .then(response => {
                        this.refresh(response);
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },
            refresh(response) {
                this.dataSet = response.data;
                this.contacts = response.data.data;

                this.loading = false;

                window.scrollTo(0, 0);
            },
            contactAdded(contact) {
                this.contacts.unshift(contact);

                flash('La création du contact a réussi.');
            },
            edit(contact) {
//                this.fetchContacts();
                console.log(contact);

                flash('Les modifications apportées au contact ont été enregistrées.')
            },
            remove(index) {
                this.contacts.splice(index, 1);

                flash('Suppression du contact réussie.');
            }
        }
    }
</script>