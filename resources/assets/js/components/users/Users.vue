<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <h1 class="mt-5">Utilisateurs</h1>
                        <span class="mt-5">
                            {{ users.length }}
                            {{ users.length == 0 || users.length == 1 ? 'utilisateur' : 'utilisateurs' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">
                <transition-group name="highlight">
                    <app-user class="card card-custom center-on-small-only"
                                 v-for="(user, index) in users"
                                 :data-user="user"
                                 :data-companies="companies"
                                 :key="user.id"
                                 @userWasDeleted="removeUser(index)"></app-user>
                </transition-group>
                <app-moon-loader :loading="loader.loading"
                                 :color="loader.color"
                                 :size="loader.size"></app-moon-loader>
            </div>
        </div>
    </div>
</template>

<script>
    import User from './User.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../../app';
    import mixins from '../../mixins';

    export default {
        props: [
            'data-users',
            'data-companies'
        ],
        data() {
            return {
                users: this.dataUsers,
                companies: this.dataCompanies
            };
        },
        mixins: [mixins],
        components: {
            'app-user': User,
            'app-moon-loader': MoonLoader
        },
        created() {
            eventBus.$on('userWasUpdated', (data) => {
                this.updateUser(data);
            })
        },
        methods: {
            updateUser(data) {
                for (let user of this.users) {
                    if (data.id === user.id) {
                        user.username = data.username;
                    }
                }
                flash({
                    message: 'Les modifications apportées à l\'utilisateur ont été enregistrées.',
                    level: 'success'
                });
            },
            removeUser(index) {
                this.users.splice(index, 1);
                flash({
                    message: 'Suppression de l\'utilisateur réussie.',
                    level: 'success'
                });
            }
        }
    }
</script>