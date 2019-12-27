<template>
    <v-select
        class="limit-width"
        required
        multiple
        :items="options"
        item-text="label"
        item-value="value"
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
