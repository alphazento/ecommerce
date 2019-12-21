<template>
    <v-switch
        v-model="innerValue"
        @change="valueChanged"
        color="purple"
    ></v-switch>
</template>

<script>
import BaseLabel from "./Label";
export default {
    methods: {
        getValue() {
            this.innerValue = !!this.innerValue;
            return this.innerValue;
        }
    },
    extends: BaseLabel
};
</script>
