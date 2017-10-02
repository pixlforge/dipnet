<template>
    <button class="btn btn-block btn-sm btn-black light"
            @click.prevent="sendConfirmationAgain">
        <slot>
            Renvoyer l'email de confirmation
        </slot>
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