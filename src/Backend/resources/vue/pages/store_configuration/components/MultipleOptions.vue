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
import BaseText from "./Text"
export default {
    extends: BaseText
};
</script>
