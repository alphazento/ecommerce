<template>
    <v-text-field
        single-line
        outlined
        dense
        :clearable="clearable"
        v-model="innerValue"
        @change="valueChanged"
        @click:clear="cleared"
    >
    </v-text-field>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig,
    props: {
        clearable: Boolean
    },
    methods: {
        cleared() {
            this.innerValue = '';
            this.valueChanged();
        }
    }
};
</script>
