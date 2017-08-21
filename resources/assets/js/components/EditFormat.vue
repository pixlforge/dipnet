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
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="updateFormat">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Modifier le format</h3>

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
                                           placeholder="e.g. A4"
                                           v-model.trim="form.name"
                                           required autofocus>
                                    <div class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
                                </div>

                                <!--Height-->
                                <div class="form-group my-5">
                                    <label for="height">Hauteur</label>
                                    <span class="required">requis</span>
                                    <input type="number"
                                           id="height"
                                           name="height"
                                           class="form-control"
                                           placeholder="e.g. 297mm"
                                           v-model.trim="form.height"
                                           required>
                                    <div class="help-block" v-if="form.errors.has('height')" v-text="form.errors.get('height')"></div>
                                </div>

                                <!--Width-->
                                <div class="form-group my-5">
                                    <label for="width">Largeur</label>
                                    <span class="required">requis</span>
                                    <input type="number"
                                           id="width"
                                           name="width"
                                           class="form-control"
                                           placeholder="e.g. 210mm"
                                           v-model.trim="form.width"
                                           required>
                                    <div class="help-block" v-if="form.errors.has('width')" v-text="form.errors.get('width')"></div>
                                </div>

                                <!--Surface-->
                                <div class="form-group my-5">
                                    <label for="surface">Surface</label>
                                    <input type="text"
                                           id="surface"
                                           name="surface"
                                           class="form-control"
                                           placeholder="e.g. 62'500mm2"
                                           v-model.trim="form.surface">
                                    <div class="help-block" v-if="form.errors.has('surface')" v-text="form.errors.get('surface')"></div>
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
                                                @click.prevent="updateFormat">
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
    import {eventBus} from '../app';

    export default {
        props: ['data'],
        data() {
            return {
                form: new Form({
                    name: this.data.name,
                    height: this.data.height,
                    width: this.data.width,
                    surface: this.data.surface
                }),
                format: 'TODO',
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
            updateFormat() {
                this.loading = true;

                this.form.put('/formats/' + this.form.id)
                    .then(() => {
                        eventBus.$emit('formatWasUpdated', this.format);
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