<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <h1 class="mt-5">{{ company.name }}</h1>
                        <span class="light mt-5 mr-3">
                            {{ data.user.length }}
                            {{ data.user.length == 0 || data.user.length == 1 ? 'membre' : 'membres' }}
                        </span>
                    </div>

                    <app-invite-member @memberWasAdded="addMember"></app-invite-member>

                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">

                <h3 class="light mb-5">Membres de {{ company.name }}</h3>

                <transition-group name="highlight">
                    <app-company-member class="card card-custom center-on-small-only"
                                        v-for="(member, index) in data.user"
                                        :member="member"
                                        :key="member.id"
                                        @memberWasDeleted="removeMember(index)">
                    </app-company-member>
                </transition-group>
                <app-moon-loader :loading="loader.loading" :color="loader.color" :size="loader.size"></app-moon-loader>
            </div>
        </div>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import CompanyMember from './CompanyMember.vue';
    import InviteMember from './InviteMember.vue';
    import {eventBus} from '../app';
    import mixins from '../mixins';

    export default {
        props: ['data'],
        data() {
            return {
                company: this.data
            };
        },
        components: {
            'app-company-member': CompanyMember,
            'app-invite-member': InviteMember,
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {
            addMember(member) {
                this.company.user.unshift(member);
                flash({
                    message: `L'invitation à ${member.email} a bien été envoyée!`,
                    level: 'success'
                });
            },
            removeMember() {
                console.log('remove a member');
            }
        }
    }
</script>