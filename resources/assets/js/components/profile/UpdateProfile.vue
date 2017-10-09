<template>
    <a class="btn btn-lg btn-black mt-4" @click="updateProfile">
        <i class="fal fa-cog mr-2"></i>
        Mettre à jour le compte
    </a>
</template>

<script>
    export default {
        methods: {
            updateProfile() {
                alert('Update Profile');
            }
        }
    }
</script>