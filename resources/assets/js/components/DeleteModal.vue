<template>
    <div class="delete-modal">
        {{ endpoint }}
    </div>
</template>

<script>
    export default {
        props: {
            endpoint: {
                type: String
            }
        },

        mounted() {
            console.log(this.endpoint);
        }
    }
</script>
