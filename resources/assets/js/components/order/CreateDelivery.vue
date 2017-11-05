<template>
    <div>
        <div class="d-flex justify-content-between">

            <div class="d-flex align-items-start">
                <!--Delivery Number-->
                <div class="badge badge-order" v-text="deliveryNumber"></div>

                <!--Contact-->
                <div class="d-flex align-items-top mt-2 mb-4">
                    <h3 class="light mr-3">Livraison à</h3>

                    <!--Dropdown-->
                    <app-dropdown :data="contacts"
                                  :add-contact-component="true"
                                  @itemWasSelected="selectContact">
                        <slot>
                            <h3 class="light v-dropdown-label">
                                <strong class="v-dropdown-label-content">{{ selectedContact }}</strong>
                                <i class="fas fa-caret-down ml-3"></i>
                            </h3>
                        </slot>
                    </app-dropdown>
                </div>
            </div>

            <p class="note-label mt-2" @click="removeNote" v-if="showNote">Retirer la note</p>
            <p class="note-label mt-2" @click="toggleNote" v-else>Ajouter une note</p>

        </div>

        <transition name="fade">
            <textarea class="v-order-textarea"
                      placeholder="Faîtes nous part de vos commentaires pour cette livraison ici."
                      @blur="updateNote"
                      v-model="delivery.note"
                      v-if="showNote"></textarea>
        </transition>

        <transition-group name="order">
            <app-document class="card card-custom center-on-small-only"
                          v-for="(document, index) in deliveryDocuments"
                          :key="document"
                          :data-order="order"
                          :data-delivery="delivery"
                          :data-document="document"
                          :data-formats="formats"
                          :data-articles="articles">
            </app-document>
        </transition-group>

        <div :id="'delivery-file-upload-' + delivery.id" class="dropzone"></div>

    </div>
</template>

<script>
    import AddContact from '../contact/AddContact.vue';
    import Document from './Document.vue';
    import Dropzone from 'dropzone';
    import mixins from '../../mixins';

    export default {
        props: [
            'data-order',
            'data-delivery',
            'data-delivery-number',
            'data-contacts',
            'data-documents',
            'data-formats',
            'data-articles'
        ],
        data() {
            return {
                order: this.dataOrder,
                delivery: this.dataDelivery,
                deliveryNumber: this.dataDeliveryNumber,
                contacts: this.dataContacts,
                documents: this.dataDocuments,
                formats: this.dataFormats,
                articles: this.dataArticles,
                selectedContact: 'Contact',
                showNote: false
            };
        },
        created() {
            if (this.dataDelivery.contact) {
                this.selectedContact = this.dataDelivery.contact.name;
            }

            if (this.dataDelivery.note) {
                this.showNote = true;
            }
        },
        mounted() {
            Dropzone.autoDiscover = false;

            let drop = new Dropzone('#delivery-file-upload-' + this.delivery.id, {
                createImageThumbnails: false,
                url: '/orders/' + this.order.reference + '/' + this.delivery.reference,
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                },
                dictRemoveFile: "Supprimer",
                dictCancelUpload: "Annuler",
                dictDefaultMessage: "<span>Glissez-déposez des fichiers ici pour les télécharger ou</span> <span class='ml-3'><strong>choisissiez vos fichiers</strong>.</span>",
                dictFallbackMessage: "Votre navigateur est trop ancien ou incompatible. Changez-le ou mettez-le à jour.",
            });

            drop.on('success', (file, response) => {
                file.id = response.id;
                this.documents.push(response);
                file.previewElement.classList.add("dz-hidden");
                flash({
                    message: "Votre document a bien été téléchargé!",
                    level: 'success'
                });
            });

            drop.on('removedfile', file => {
                axios.delete('/orders/' + this.order.reference + '/' + this.delivery.reference + '/' + file.id)
                    .catch(error => {
                        drop.emit('addedfile', {
                            id: file.id,
                            name: file.name,
                            size: file.size
                        });
                    });
            });
        },
        mixins: [mixins],
        components: {
            'app-add-contact': AddContact,
            'app-document': Document
        },
        computed: {
            deliveryDocuments() {
                return this.documents.filter(document => {
                    return document.delivery_id == this.delivery.id;
                });
            }
        },
        methods: {
            selectContact(contact) {
                this.selectedContact = contact.name;
                this.delivery.contact_id = contact.id;
                this.update();
            },
            update() {
                axios.put('/deliveries/' + this.delivery.reference, this.delivery);
            },
            toggleNote() {
                this.showNote = !this.showNote;
            },
            updateNote() {
                axios.put('/deliveries/' + this.delivery.reference + '/note', this.delivery);
            },
            removeNote() {
                axios.delete('/deliveries/' + this.delivery.reference + '/note', this.delivery);
                this.delivery.note = '';
                this.showNote = false;
                flash({
                    message: "La note a été supprimée.",
                    level: 'success'
                });
            }
        }
    }
</script>

<style scoped>
    .note-label {
        cursor: pointer;
    }

    .note-label:hover {
        text-decoration: underline;
    }
</style>