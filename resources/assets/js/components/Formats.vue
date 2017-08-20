<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <h1 class="mt-5">Formats</h1>
                        <span class="mt-5">
                            {{ formats.length }}
                            {{ formats.length == 0 || formats.length == 1 ? 'résultat' : 'résultats' }}
                        </span>
                        <app-add-format @formatWasCreated="addFormat"></app-add-format>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">
                <transition-group name="highlight">
                    <app-format class="card card-custom center-on-small-only"
                                v-for="(format, index) in formats"
                                :data="format"
                                :key="format"
                                @formatWasDeleted="removeFormat(index)">
                    </app-format>
                </transition-group>
                <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>
            </div>
        </div>
    </div>
</template>

<script>
    import Format from './Format.vue';
    import AddFormat from './AddFormat.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../app';

    export default {
        props: ['data'],
        data() {
            return {
                formats: this.data,
                color: '#fff',
                size: '96px',
                loading: false
            };
        },
        components: {
            'app-format': Format,
            'app-add-format': AddFormat,
            MoonLoader
        },
        methods: {
            addFormat(format) {
                this.formats.unshift(format);

                flash('La création du format a réussi.');
            },
            removeFormat(index) {
                this.formats.splice(index, 1);

                flash('Suppression du format réussie.');
            }
        }
    }
</script>