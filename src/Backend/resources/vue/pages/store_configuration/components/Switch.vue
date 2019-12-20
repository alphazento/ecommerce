<template>
    <v-switch
        v-model="innerValue"
        @change="valueChanged"
        color="purple"
    ></v-switch>
</template>

<script>
import BaseText from "./Text"
export default {
     props: {
        value: {
            type: Boolean
        }
    },
    extends: BaseText
};
</script>
