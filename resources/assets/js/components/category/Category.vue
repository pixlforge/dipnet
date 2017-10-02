<template>
    <div>
        <div class="col col-lg-1 hidden-md-down">
            <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
        </div>

        <div class="col-12 col-lg-2">

            <!--Name-->
            <h5 class="mb-0" v-text="category.name"></h5>
        </div>

        <div class="col-12 col-lg-2">

        </div>

        <div class="col-12 col-lg-3">

        </div>

        <div class="col-12 col-lg-3">

            <!--Created at-->
            <div>
                <span class="card-content"><em>Créé:</em></span>
                <span class="card-content ml-1" v-text="getDate(category.created_at)"></span>
            </div>

            <!--Modified at-->
            <div>
                <span class="card-content"><em>Modifié:</em></span>
                <span class="card-content ml-1" v-text="getDate(category.updated_at)"></span>
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

                    <app-edit-category :data="category"></app-edit-category>

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
    import EditCategory from './EditCategory.vue';
    import moment from 'moment';
    import mixins from '../../mixins';

    export default {
        props: ['data'],
        data() {
            return {
                category: this.data,
                momentFormat: 'LLL',
                momentLocale: 'fr'
            };
        },
        components: {
            'app-edit-category': EditCategory
        },
        methods: {
            destroy() {
                axios.delete('/categories/' + this.category.id);
                this.$emit('categoryWasDeleted', this.category.id);
            },

            getDate(date) {
                return moment(date).locale(this.momentLocale).format(this.momentFormat);
            }
        }
    }
</script>