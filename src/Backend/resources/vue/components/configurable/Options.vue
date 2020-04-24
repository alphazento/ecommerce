<template>
    <v-select
        class="limit-width"
        :items="compOptions"
        item-text="label"
        item-value="value"
        required
        v-model="innerValue"
        @change="valueChanged"
    ></v-select>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig,
    props: {
        clearable: Boolean
    },
    computed: {
        compOptions() {
            if (this.clearable) {
                let options = this.options;
                options.unshift({label: '(clear)', value: null});
                return options;
            } else {
                return this.options;
            }
        }
    }
};
</script>
