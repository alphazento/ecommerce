<template>
    <v-select
        class="limit-width"
        :items="options"
        required
        v-model="innerValue"
        @change="valueChanged"
    ></v-select>
</template>

<script>
import BaseLabel from "./Label";
export default {
    extends: BaseLabel
};
</script>
