<template>
    <v-text-field
        single-line
        outlined
        dense
        :clearable="clearable"
        v-model="innerValue"
        @change="valueChanged"
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
    mounted() {
        console.log("clearable", this.clearable);
    }
};
</script>
