<template>
    <v-chip :color="enabled ? 'success' : 'error'">
        <v-icon v-if="enabled">mdi-check</v-icon>
        <span v-if="!enabled">X</span>
    </v-chip>
</template>

<script>
export default {
    props: {
        value: {
            type: String | Number
        }
    },
    computed: {
        enabled() {
            return !!this.value;
        }
    }
};
</script>
