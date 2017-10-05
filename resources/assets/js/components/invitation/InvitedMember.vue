<template>
    <div>
        <div class="col-lg-1 hidden-md-down">
            <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
        </div>

        <div class="col-12 col-lg-3">

            <!--Username-->
            <h5 class="mb-0" v-text="invitation.email"></h5>
        </div>

        <!--Controls-->
        <div class="col-12 col-lg-8 center-on-small-only text-lg-right">
            <div class="dropdown">
                <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="dropdownMenuLink">

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
    export default {
        props: ['invitation'],
        methods: {
            destroy() {
                this.$emit('invitationWasDeleted', this.invitation);
            }
        }
    }
</script>