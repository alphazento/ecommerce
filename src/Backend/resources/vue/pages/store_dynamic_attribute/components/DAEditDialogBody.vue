<template>
    <v-card>
        <v-card-title class="headline">
            Edit Attribute
        </v-card-title>

        <v-card-text>
            {{ item }}
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="green darken-1" text @click="closeDialog(false)">
                Disard
            </v-btn>

            <v-btn color="green darken-1" text @click="dialog = false">
                Save
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props: {
        item: {
            type: Object
        }
    },
    methods: {
        closeDialog(ignore) {
            this.$emit("close", ignore);
        }
    }
};
</script>
