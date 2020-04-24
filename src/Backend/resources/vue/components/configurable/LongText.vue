<template>
    <v-textarea
        filled
        auto-grow
        rows="2"
        row-height="20"
        v-model="innerValue"
        @change="valueChanged"
    ></v-textarea>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig
};
</script>
