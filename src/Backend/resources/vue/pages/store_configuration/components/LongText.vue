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
import BaseText from "./Text"
export default {
    extends: BaseText
};
</script>
