<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <h1 class="mt-5">Commandes</h1>
                        <span class="mt-5">
                            {{ orders.length }}
                            {{ orders.length == 0 || orders.length == 1 ? 'commande' : 'commandes' }}
                        </span>

                        <a @click="redirect()" class="btn btn-lg btn-black light mt-5" role="button">
                            <i class="fal fa-plus-circle mr-2"></i>
                            Nouvelle commande
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">

                <transition-group name="highlight">
                    <app-order class="card card-custom center-on-small-only"
                                 v-for="(order, index) in orders"
                                 :data-order="order"
                                 :key="order"
                                 @orderWasDeleted="removeOrder(index)"></app-order>
                </transition-group>

                <app-moon-loader :loading="loader.loading"
                                 :color="loader.color"
                                 :size="loader.size"></app-moon-loader>
            </div>
        </div>
    </div>
</template>

<script>
    import Order from './Order.vue';
    import AddOrder from './CreateOrder.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../../app';
    import mixins from '../../mixins';

    export default {
        props: ['data-orders'],
        data() {
            return {
                orders: this.dataOrders
            };
        },
        mixins: [mixins],
        components: {
            'app-order': Order,
            'app-add-order': AddOrder,
            'app-moon-loader': MoonLoader
        },
        created() {
            eventBus.$on('orderWasUpdated', (data) => {
                this.updateOrder(data);
            })
        },
        methods: {
            redirect() {
                window.location.pathname = '/orders/create';
            },
            updateOrder(data) {
                for (let order of this.orders) {
                    if (data.id === order.id) {
                        // TODO: Update attributes
                    }
                }
                flash({
                    message: 'Les modifications apportées à la commande ont été enregistrées.',
                    level: 'success'
                });
            },
            removeOrder(index) {
                this.orders.splice(index, 1);
                flash({
                    message: 'Suppression de la commande réussie.',
                    level: 'success'
                });
            }
        }
    }
</script>