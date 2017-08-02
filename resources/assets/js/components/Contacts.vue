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

                        <add-contact @created="add"></add-contact>

                    </div>
                </div>
            </div>
        </div>

        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">

                <paginator :dataSet="dataSet" @updated="fetchContacts" class="my-2"></paginator>

                <div v-for="(contact, index) in contacts">

                    <contact class="card card-custom center-on-small-only"
                             :data="contact"
                             :key="contact.id"
                             @deleted="remove(index)"></contact>

                </div>

                <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>

                <paginator :dataSet="dataSet" @updated="fetchContacts" class="mt-4"></paginator>

            </div>
        </div>
    </div>
</template>

<script>
    import Contact from './Contact.vue';
    import AddContact from './AddContact.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';

    export default {
        props: ['data'],

        data() {
            return {
                dataSet: false,
                contacts: this.data,
                color: '#fff',
                size: '96px',
                loading: false
            }
        },

        components: { Contact, AddContact, MoonLoader },

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

                window.scrollTo(0, 0);
            },

            add(contact) {
                this.contacts.unshift(contact);

                flash('Le contact a bien été créé.');
            },

            remove(index) {
                this.contacts.splice(index, 1);

                flash('Le contact a bien été supprimé.');
            }
        }
    }
</script>