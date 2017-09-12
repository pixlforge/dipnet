<template>
    <button class="btn btn-block btn-black"
            @click.prevent="sendConfirmationAgain">
        Renvoyer l'email de confirmation
    </button>
</template>

<script>
    export default {
        methods: {
            sendConfirmationAgain() {
                alert('TODO: re-send confirmation email');
            }
        }
    }
</script>