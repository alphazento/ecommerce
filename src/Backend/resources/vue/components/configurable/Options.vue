<template>
    <v-select
        class="limit-width"
        :items="options"
        item-text="label"
        item-value="value"
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
