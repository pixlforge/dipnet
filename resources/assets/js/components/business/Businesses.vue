<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <h1 class="mt-5">Affaires</h1>
                        <span class="mt-5">
                            {{ businesses.length }}
                            {{ businesses.length == 0 || businesses.length == 1 ? 'résultat' : 'résultats' }}
                        </span>
                        <app-add-business @businessWasCreated="addBusiness"
                                          :companies="companies"></app-add-business>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">
                <transition-group name="highlight">
                    <app-business class="card card-custom center-on-small-only"
                                  v-for="(business, index) in businesses"
                                  :business="business"
                                  :key="business"
                                  @businessWasDeleted="removeBusiness(index)">
                    </app-business>
                </transition-group>
                <app-moon-loader :loading="loader.loading" :color="loader.color" :size="loader.size">
                </app-moon-loader>
            </div>
        </div>
    </div>
</template>

<script>
    import Business from './Business.vue';
    import AddBusiness from './AddBusiness.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../../app';
    import mixins from '../../mixins';

    export default {
        props: ['businesses-data', 'companies-data'],
        data() {
            return {
                businesses: this.businessesData,
                companies: this.companiesData
            };
        },
        components: {
            'app-business': Business,
            'app-add-business': AddBusiness,
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        created() {
            eventBus.$on('businessWasUpdated', (data) => {
                this.updateBusiness(data);
            })
        },
        methods: {
            addBusiness(business) {
                this.businesses.unshift(business);
                flash('La création du format a réussi.');
            },
            updateBusiness(data) {
                for (let business of this.businesses) {
                    if (data.id === business.id) {
                        business.name = data.name;
                        business.reference = data.reference;
                        business.description = data.description;
                        business.company_id = data.company_id;
                        business.contact_id = data.contact_id;
                    }
                }
                flash('Les modifications apportées au format ont été enregistrées.')
            },
            removeBusiness(index) {
                this.businesses.splice(index, 1);
                flash('Suppression du format réussie.');
            }
        }
    }
</script>