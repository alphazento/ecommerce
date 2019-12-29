<template>
    <v-text-field
        single-line
        outlined
        dense
        v-model="innerValue"
        @change="valueChanged"
    >
    </v-text-field>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig
};
</script>
