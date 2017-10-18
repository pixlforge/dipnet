<template>
    <div>
        <div class="col col-lg-1 hidden-md-down">
            <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
        </div>

        <div class="col-12 col-lg-2">

            <!--Reference-->
            <h5 class="mb-0" v-text="article.reference"></h5>
        </div>

        <div class="col-12 col-lg-3">

            <!--Description-->
            <span class="card-content" v-text="article.description"></span>
        </div>

        <div class="col-12 col-lg-2">

            <!--Type-->
            <div class="card-content">
                <span class="card-label">Type:</span>
                <span>{{ article.type | capitalize }}</span>
            </div>

            <!--Category-->
            <div class="card-content">
                <span class="card-label">Catégorie:</span>
                <span v-text="article.category.name"></span>
            </div>
        </div>

        <div class="col-12 col-lg-3">

            <!--Created at-->
            <div class="card-content">
                <span class="card-label">Créé:</span>
                <span v-text="getDate(article.created_at)"></span>
            </div>

            <!--Modified at-->
            <div class="card-content">
                <span class="card-label">Modifié:</span>
                <span v-text="getDate(article.updated_at)"></span>
            </div>
        </div>

        <div class="col-12 col-lg-1 center-on-small-only text-lg-right">
            <div class="dropdown">
                <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fal fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="dropdownMenuLink">

                    <app-edit-article :data-article="article"
                                      :data-categories="categories"></app-edit-article>

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
    import EditArticle from './EditArticle.vue';
    import moment from 'moment';
    import mixins from '../../mixins';

    export default {
        props: [
            'data-article',
            'data-categories'
        ],
        data() {
            return {
                article: this.dataArticle,
                categories: this.dataCategories
            };
        },
        mixins: [mixins],
        components: {
            'app-edit-article': EditArticle
        },
        methods: {
            destroy() {
                axios.delete('/articles/' + this.article.id);
                this.$emit('articleWasDeleted', this.article.id);
            },
            getDate(date) {
                return moment(date).locale(this.momentLocale).format(this.momentFormat);
            }
        }
    }
</script>