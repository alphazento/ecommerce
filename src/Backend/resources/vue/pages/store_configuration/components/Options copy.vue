<template>
    <v-select
        class="limit-width"
        :items="options"
        item-text="label"
        item-value="value"
        required
        v-model="innerValue"
        @change="valueChanged"
        multiple
    ></v-select>
</template>

<script>
import BaseText from "./Text"
export default {
    extends: BaseText
};
</script>
