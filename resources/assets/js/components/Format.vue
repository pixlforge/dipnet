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
            <div v-if="format.height">
                <span class="card-content"><em>Hauteur:</em></span>
                <span class="card-content" v-text="format.height"></span>
            </div>

            <!--Width-->
            <div v-if="format.width">
                <span class="card-content"><em>Largeur:</em></span>
                <span class="card-content" v-text="format.width"></span>
            </div>
        </div>

        <div class="col-12 col-lg-3">

            <!--Surface-->
            <div v-if="format.surface">
                <span class="card-content"><em>Surface:</em></span>
                <span class="card-content" v-if="format.surface" v-text="format.surface"></span>
            </div>
        </div>

        <div class="col-12 col-lg-3">

            <!--Created at-->
            <div>
                <span class="card-content"><em>Créé:</em></span>
                <span class="card-content ml-1" v-text="getDate(format.created_at)"></span>
            </div>

            <!--Modified at-->
            <div>
                <span class="card-content"><em>Modifié:</em></span>
                <span class="card-content ml-1" v-text="getDate(format.updated_at)"></span>
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
                    <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="Dropdown menu link">

                    <!--<edit-contact :data="contact"></edit-contact>-->

                    <a class="dropdown-item text-danger" role="button" @click.prevent="destroy">
                        <i class="fa fa-trash"></i>
                        <span class="ml-3">Supprimer</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['data'],
        data() {
            return {
                format: this.data,
                momentFormat: 'LLL',
                momentLocale: 'fr'
            };
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