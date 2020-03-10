<template>
    <v-row
        align="center"
        class="mx-0"
    >
        <v-rating
            :value="4.5"
            color="amber"
            dense
            half-increments
            readonly
            size="18"
            >
            </v-rating>
        <div class="grey--text ml-4">4.5 (413)</div>
    </v-row>
</template>

<script>
export default {
    props: {
        product: {
            type: Object
        }
    }  
};
</script>
