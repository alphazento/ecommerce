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
import BaseLabel from "./Label";
export default {
    extends: BaseLabel
};
</script>
