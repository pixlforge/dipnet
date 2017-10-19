<template>
    <div>
        <div class="col col-lg-1 hidden-md-down">
            <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
        </div>

        <div class="col-12 col-lg-2">

            <!--Name-->
            <h5 class="mb-0" v-text="format.name"></h5>
        </div>

        <div class="col-12 col-lg-2">

            <!--Height-->
            <div class="card-content">
                <span class="card-label">Hauteur:</span>
                <span v-text="format.height"></span>
            </div>

            <!--Width-->
            <div class="card-content">
                <span class="card-label">Largeur:</span>
                <span v-text="format.width"></span>
            </div>
        </div>

        <div class="col-12 col-lg-3">

            <!--Surface-->
            <div class="card-content" v-if="format.surface">
                <span class="card-label">Surface:</span>
                <span v-text="format.surface"></span>
            </div>
        </div>

        <div class="col-12 col-lg-3">

            <!--Created at-->
            <div class="card-content">
                <span class="card-label">Créé:</span>
                <span v-text="getDate(format.created_at)"></span>
            </div>

            <!--Modified at-->
            <div class="card-content">
                <span class="card-label">Modifié:</span>
                <span v-text="getDate(format.updated_at)"></span>
            </div>
        </div>

        <div class="col-12 col-lg-1 center-on-small-only text-lg-right">
            <div class="dropdown">
                <a class="btn btn-transparent btn-sm"
                   type="button"
                   id="dropdownMenuLink"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fal fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="Dropdown menu link">

                    <app-edit-format :data="format"></app-edit-format>

                    <a class="dropdown-item text-danger" role="button" @click.prevent="destroy">
                        <i class="fal fa-times"></i>
                        <span class="ml-3">Supprimer</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EditFormat from './EditFormat.vue';
    import moment from 'moment';
    import mixins from '../../mixins';

    export default {
        props: ['data'],
        data() {
            return {
                format: this.data,
                momentFormat: 'LLL',
                momentLocale: 'fr'
            };
        },
        components: {
            'app-edit-format': EditFormat
        },
        methods: {
            destroy() {
                axios.delete('/formats/' + this.format.id);
                this.$emit('formatWasDeleted', this.format.id);
            },
            getDate(date) {
                return moment(date).locale(this.momentLocale).format(this.momentFormat);
            }
        }
    }
</script>