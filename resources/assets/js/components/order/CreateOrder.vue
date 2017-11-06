<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">

                        <h1 class="mt-5">Nouvelle commande</h1>

                        <div class="d-flex mt-5">
                            <!--Business-->
                            <div class="mr-5">
                                <!--Dropdown-->
                                <h6 class="h6-responsive light mr-2">Affaire</h6>
                                <app-dropdown :data="businesses" @itemWasSelected="selectBusiness">
                                    <slot>
                                        <h6 class="light v-dropdown-label">
                                            <strong class="v-dropdown-label-content">{{ selectedBusiness }}</strong>
                                            <i class="fas fa-caret-down ml-3"></i>
                                        </h6>
                                    </slot>
                                </app-dropdown>
                            </div>

                            <!--Billing Contact-->
                            <div>
                                <!--Dropdown-->
                                <h6 class="h6-responsive light mr-2">Facturation</h6>
                                <app-dropdown :data="contacts" @itemWasSelected="selectContact">
                                    <slot>
                                        <h6 class="light v-dropdown-label">
                                            <strong class="v-dropdown-label-content">{{ selectedContact }}</strong>
                                            <i class="fas fa-caret-down ml-3"></i>
                                        </h6>
                                    </slot>
                                </app-dropdown>
                            </div>
                        </div>

                        <!--Add Contact-->
                        <app-add-contact class="v-hidden"
                                         @contactWasCreated="addContact">
                        </app-add-contact>
                    </div>
                </div>
            </div>
        </div>

        <transition-group name="order">
            <div class="row bg-grey-light my-2"
                 v-for="(delivery, index) in deliveries"
                 :key="delivery">
                <div class="col-10 mx-auto my-6">
                    <app-create-delivery :data-order="order"
                                         :data-delivery="delivery"
                                         :data-delivery-number="index + 1"
                                         :data-delivery-count="deliveries.length"
                                         :data-contacts="contacts"
                                         :data-documents="documents"
                                         :data-formats="formats"
                                         :data-articles="articles"
                                         @deliveryWasRemoved="removeDelivery">
                    </app-create-delivery>
                </div>
            </div>
        </transition-group>

        <div class="row bg-grey-light bg-grey-light-hoverable my-2"
             role="button"
             @click="addDelivery">
            <div class="col-10 mx-auto my-6">
                <h4 class="text-center">
                    <i class="fal fa-plus-circle mr-2"></i>
                    <span class="light">Ajouter une livraison</span>
                </h4>
            </div>
        </div>

        <app-moon-loader :loading="loader.loading"
                         :color="loader.color"
                         :size="loader.size">
        </app-moon-loader>
    </div>
</template>

<script>
    import CreateDelivery from './CreateDelivery.vue';
    import AddContact from '../contact/AddContact.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../../mixins';
    import { eventBus } from '../../app';

    export default {
        props: [
            'data-order',
            'data-businesses',
            'data-contacts',
            'data-deliveries',
            'data-documents',
            'data-formats',
            'data-articles'
        ],
        data() {
            return {
                order: this.dataOrder,
                businesses: this.dataBusinesses,
                contacts: this.dataContacts,
                deliveries: this.dataDeliveries,
                documents: this.dataDocuments,
                formats: this.dataFormats,
                articles: this.dataArticles,
                business: 'Choisissez une affaire',
                selectedBusiness: 'Affaire',
                selectedContact: 'Contact',
                errors: {}
            };
        },
        mixins: [mixins],
        components: {
            'app-create-delivery': CreateDelivery,
            'app-add-contact': AddContact,
            'app-moon-loader': MoonLoader
        },
        created() {
            eventBus.$on('documentWasDeleted', (data) => {
                this.removeDocument(data);
            });

            if (this.dataOrder.business) {
                this.selectedBusiness = this.order.business.name;
            }

            if (this.dataOrder.contact) {
                this.selectedContact = this.order.contact.name;
            }
        },
        mounted() {
            if (!this.deliveries.length) this.addDelivery();
        },
        methods: {
            addDelivery() {
                this.toggleLoader();

                axios.post('/deliveries', { order_id: this.order.id })
                    .then(response => {
                        this.toggleLoader();
                        this.deliveries.push(response.data);
                        flash({
                            message: "Une nouvelle livraison a été ajoutée à votre commande.",
                            level: 'success'
                        });
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data.errors;
                        flash({
                            message: "Il y a eu un problème lors de la création de votre livraison.",
                            level: 'danger'
                        })
                    });
            },
            removeDocument(id) {
                let index = 0;

                for (let document of this.documents) {
                    if (document.id === id) {
                        this.documents.splice(index, 1);
                    } else {
                        index++;
                    }
                }
            },
            removeDelivery(id) {
                let index = 0;

                for (let delivery of this.deliveries) {
                    if (delivery.id === id) {
                        this.deliveries.splice(index, 1);
                    } else {
                        index++;
                    }
                }
            },
            addContact(contact) {
                this.contacts.unshift(contact);
                flash({
                    message: 'La création du contact a réussi.',
                    level: 'success'
                });
            },
            selectBusiness(business) {
                this.selectedBusiness = business.name;
                this.order.business_id = business.id;
                this.update();
            },
            selectContact(contact) {
                this.selectedContact = contact.name;
                this.order.contact_id = contact.id;
                this.update();
            },
            update() {
                axios.put('/orders/' + this.order.reference, this.order);
            }
        }
    }
</script>
