<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <h1 class="mt-5">Contacts</h1>
                        <span class="mt-5">
                            {{ contacts.length }}
                            {{ contacts.length == 0 || contacts.length == 1 ? 'résultat' : 'résultats' }}
                        </span>
                        <app-add-contact @contactWasCreated="addContact"></app-add-contact>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">
                <transition-group name="highlight">
                    <app-contact class="card card-custom center-on-small-only"
                                 v-for="(contact, index) in contacts"
                                 :data="contact"
                                 :key="contact.id"
                                 @contactWasDeleted="removeContact(index)"></app-contact>
                </transition-group>
                <app-moon-loader :loading="loader.loading"
                                 :color="loader.color"
                                 :size="loader.size"></app-moon-loader>
            </div>
        </div>
    </div>
</template>

<script>
    import Contact from './Contact.vue';
    import AddContact from './AddContact.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../../app';
    import mixins from '../../mixins';

    export default {
        props: ['data'],
        data() {
            return {
                contacts: this.data
            }
        },
        components: {
            'app-contact': Contact,
            'app-add-contact': AddContact,
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        created() {
            eventBus.$on('contactWasUpdated', (data) => {
                this.updateContact(data);
            })
        },
        methods: {
            addContact(contact) {
                this.contacts.unshift(contact);
                flash({
                    message: 'La création du contact a réussi.',
                    level: 'success'
                });
            },
            updateContact(data) {
                for (let contact of this.contacts) {
                    if (data.id === contact.id) {
                        contact.name = data.name;
                        contact.address_line1 = data.address_line1;
                        contact.address_line2 = data.address_line2;
                        contact.zip = data.zip;
                        contact.city = data.city;
                        contact.phone_number = data.phone_number;
                        contact.fax = data.fax;
                        contact.email = data.email;
                        contact.company_id = data.company_id;
                    }
                }
                flash('Les modifications apportées au contact ont été enregistrées.')
            },
            removeContact(index) {
                this.contacts.splice(index, 1);
                flash('Suppression du contact réussie.');
            }
        }
    }
</script>