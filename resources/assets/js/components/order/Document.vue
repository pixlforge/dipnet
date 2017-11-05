<template>
    <div>

        <div class="col-lg-2 px-0 text-center">
            <i class="fal fa-5x file-type-icon" :class="fileType"></i>
        </div>

        <div class="col-lg-10 px-0">
            <div class="col-lg-12 d-flex justify-content-between">
                <h2 class="h4-responsive ml-2 mt-3">{{ document.filename }}</h2>
                <span class="icon-destroy" @click="destroy">
                    <i class="fal fa-times fa-2x mr-2"></i>
                </span>
            </div>

            <div class="col-lg-12 d-flex mt-5 mb-3">
                <!--Format-->
                <div class="col-lg-3 px-0">
                    <h4 class="h6-responsive select-label">Type d'impression</h4>

                    <app-dropdown :data="formats" v-model="document.format_id">
                        <slot>
                            <p>
                                Sélectionnez un contact
                                <i class="fas fa-caret-down select-caret-delivery"></i>
                            </p>
                        </slot>
                    </app-dropdown>
                </div>

                <!--Finish-->
                <div class="col-lg-3 px-0">
                    <h4 class="h6-responsive select-label">Finition</h4>
                    <select class="custom-select order-select" v-model="document.finish">
                        <option disabled selected>Sélectionnez une finition</option>
                        <option value="plié">Plié</option>
                        <option value="roué">Roulé</option>
                    </select>
                    <i class="fal fa-caret-down select-caret"></i>
                </div>

                <!--Article-->
                <div class="col-lg-3 px-0">
                    <h4 class="h6-responsive select-label">Option</h4>
                    <select class="custom-select order-select" v-model="document.article_id">
                        <option disabled selected>Sélectionnez une option</option>
                        <option v-for="(article, index) in articles"
                                :value="article.id"
                                v-text="article.reference"></option>
                    </select>
                    <i class="fal fa-caret-down select-caret"></i>
                </div>

                <!--Quantity-->
                <div class="col-lg-3 px-0">
                    <h4 class="h6-responsive select-label">Quantité</h4>
                    <input type="number" class="form-control" v-model.number="document.quantity">
                </div>
            </div>
        </div>

        <app-moon-loader :loading="loader.loading"
                         :color="loader.color"
                         :size="loader.size">
        </app-moon-loader>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../../mixins';
    import { eventBus } from '../../app';

    export default {
        props: [
            'data-order',
            'data-delivery',
            'data-document',
            'data-formats',
            'data-articles'
        ],
        data() {
            return {
                order: this.dataOrder,
                delivery: this.dataDelivery,
                document: {
                    id: this.dataDocument.id,
                    filename: this.dataDocument.filename,
                    mime_type: this.dataDocument.mime_type,
                    size: this.dataDocument.size,
                    quantity: 1,
                    finish: 'Sélectionnez une finition',
                    format_id: 'Sélectionnez un format',
                    delivery_id: this.dataDocument.delivery_id,
                    article_id: 'Sélectionnez une option',
                },
                formats: this.dataFormats,
                articles: this.dataArticles
            };
        },
        mixins: [mixins],
        components: {
            'app-moon-loader': MoonLoader
        },
        computed: {
            fileType() {

                // Images
                if (this.document.mime_type === 'image/jpeg' ||
                    this.document.mime_type === 'image/png' ||
                    this.document.mime_type === 'image/gif' ||
                    this.document.mime_type === 'image/vnd.adobe.photoshop' ||
                    this.document.mime_type === 'application/postscript') {
                    return 'fa-file-image';
                }

                // PDF
                if (this.document.mime_type === 'application/pdf') return 'fa-file-pdf';

                // Word
                if (this.document.mime_type === 'application/msword' || this.document.mime_type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    return 'fa-file-word';
                }

                // Excel
                if (this.document.mime_type === 'application/vnd.ms-excel' || this.document.mime_type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    return 'fa-file-excel';
                }

                // Powerpoint
                if (this.document.mime_type === 'application/vnd.ms-powerpoint' || this.document.mime_type === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
                    return 'fa-file-powerpoint';
                }

                return 'fa-file';
            }
        },
        methods: {
            destroy() {
                this.toggleLoader();

                axios.delete('/orders/' + this.order.reference + '/' + this.delivery.reference + '/' + this.document.id).then(() => {
                    this.toggleLoader();
                    flash({
                        message: "Le document a bien été supprimé.",
                        level: 'success'
                    });
                }).catch(error => {
                    flash({
                        message: "Le document n'a pas pu être supprimé.",
                        level: 'danger'
                    });
                });
                eventBus.$emit('documentWasDeleted', this.document.id);
            }
        }
    }
</script>
