<template>
    <div>
        <div class="col col-lg-1 hidden-md-down">
            <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
        </div>

        <div class="col-12 col-lg-2">

            <!--Name-->
            <h5 class="mb-0" v-text="contact.name"></h5>
        </div>

        <div class="col-12 col-lg-2">

            <!--Address line 1-->
            <div v-if="contact.address_line1">
                <span class="card-content" v-text="contact.address_line1"></span>
            </div>

            <!--Address line 2-->
            <div v-if="contact.address_line2">
                <span class="card-content" v-text="contact.address_line2"></span>
            </div>

            <!--Zip & City-->
            <div v-if="contact.zip || contact.city">
                <span class="card-content" v-if="contact.zip" v-text="contact.zip"></span>
                <span class="card-content" v-if="contact.city" v-text="contact.city"></span>
            </div>
        </div>

        <div class="col-12 col-lg-3">

            <!--Phone-->
            <div v-if="contact.phone_number">
                <span class="card-content"><em>Tel:</em></span>
                <span class="card-content" v-text="contact.phone_number"></span>
            </div>

            <!--Fax-->
            <div v-if="contact.fax">
                <span class="card-content"><em>Fax:</em></span>
                <span class="card-content" v-text="contact.fax"></span>
            </div>

            <!--Email-->
            <div v-if="contact.email">
                <span class="card-content"><em>Email:</em></span>
                <span class="card-content" v-text="contact.email"></span>
            </div>
        </div>

        <div class="col-12 col-lg-3">

            <!--Company-->
            <div v-if="contact.company">
                <span class="card-content"><em>Société:</em></span>
                <span class="card-content" v-text="contact.company.name"></span>
            </div>

            <!--Created at-->
            <div>
                <span class="card-content"><em>Créé:</em></span>
                <span class="card-content ml-1" v-text="getDate(contact.created_at)"></span>
            </div>

            <!--Modified at-->
            <div>
                <span class="card-content"><em>Modifié:</em></span>
                <span class="card-content ml-1" v-text="getDate(contact.updated_at)"></span>
            </div>

            <!--Created by-->
            <div v-if="contact.created_by_username">
                <span class="card-content"><em>Par:</em></span>
                <span class="card-content ml-1" v-text="contact.created_by_username"></span>
            </div>
        </div>

        <div class="col-12 col-lg-1 center-on-small-only text-lg-right">
            <div class="dropdown">
                <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="dropdownMenuLink">
                    <!--<a class="dropdown-item text-success" href="">-->
                    <!--<i class="fa fa-refresh"></i>-->
                    <!--<span class="ml-3">Restaurer</span>-->
                    <!--</a>-->

                    <edit-contact :data="contact"></edit-contact>

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
    import EditContact from './EditContact.vue';
    import moment from 'moment';

    export default {
        props: ['data'],
        data() {
            return {
                contact: this.data,
                format: 'LLL',
                locale: 'fr'
            }
        },
        components: { EditContact },
        methods: {
            destroy() {
                axios.delete('/contacts/' + this.contact.id);

                this.$emit('contactWasDeleted', this.contact.id);
            },

            getDate(date) {
                return moment(date).locale(this.locale).format(this.format);
            }
        }
    }
</script>