<template>
    <div>
        <h3 class="mt-7 mb-5">Avatar</h3>

        <div class="form-group my-5">
            <label for="avatar" class="btn btn-lg btn-black">
                <i class="fal fa-folder-open mr-2"></i>
                Sélectionner une image
            </label>
            <input type="file"
                   name="avatar"
                   id="avatar"
                   @change="fileChange">
            <div class="help-block" v-if="errors.length" v-text="errors[0]"></div>
        </div>

        <div class="form-group my-5">
            <img :src="avatar.path" class="avatar-upload" alt="Avatar à modifier" v-if="avatar.path">
            <img :src="currentAvatar" class="avatar-upload" alt="Avatar actuel" v-else>
        </div>

        <div class="form-group my-5" v-if="avatar.path">
            <button class="btn btn-lg btn-black" @click="update">
                <i class="fal fa-upload mr-2"></i>
                Mettre à jour l'avatar
            </button>
        </div>

        <app-moon-loader :loading="loader.loading"
                         :color="loader.color"
                         :size="loader.size"></app-moon-loader>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../../mixins';

    export default {
        props: ['data-avatar'],
        data() {
            return {
                currentAvatar: this.dataAvatar,
                avatar: {
                    id: null,
                    path: this.currentAvatar
                },
                endpoint: '/profile/avatar',
                errors: {},
                sendAs: 'avatar'
            };
        },
        mixins: [mixins],
        components: {
            'app-moon-loader': MoonLoader
        },
        methods: {
            fileChange(event) {
                this.upload(event);
            },
            upload(event) {
                this.toggleLoader();

                axios.post(this.endpoint, this.packageUploads(event))
                    .then((response) => {
                        this.toggleLoader();
                        this.avatar = response.data;
                        flash({
                            message: "Avatar valide. Vous pouvez sauver cette image en tant qu'avatar personnel.",
                            level: 'success'
                        });
                    })
                    .catch((error) => {
                        this.toggleLoader();

                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors.avatar;
                            flash({
                                message: this.errors[0],
                                level: 'danger'
                            });
                            return;
                        }

                        this.errors = "Une erreur est survenue. Veuillez réessayer plus tard.";
                    })
            },
            packageUploads(event) {
                let fileData = new FormData();

                fileData.append(this.sendAs, event.target.files[0]);

                return fileData;
            },
            update() {
                this.toggleLoader();

                axios.patch('/profile/avatar', {
                    avatar: {
                        id: this.avatar.id
                    }
                })
                    .then(() => {
                        this.toggleLoader();
                        flash({
                            message: "Votre avatar a bien été mis à jour.",
                            level: 'success'
                        });
                    })
                    .catch(() => {
                        this.toggleLoader();
                        flash({
                            message: "Il y a eu un problème, votre compte n'a pas été mis à jour.",
                            level: 'danger'
                        })
                    })
            }
        }
    }
</script>

<style>
    label {
        font-size: .875rem !important;
    }

    input {
        display: none;
    }
</style>