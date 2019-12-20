<template>
    <v-text-field
        single-line
        outlined
        dense
        v-model="innerValue"
        @change="valueChanged"
        >
    </v-text-field>
</template>

<script>
export default {
    props: {
        accessor: {
            type: String
        },
        title: {
            type: String
        },
        ui: {
            type: String
        },
        value: {
            type: String
        },
        options: {
            type: Array
        }
    },
    data() {
        return {
            oldVal: this.value,
            innerValue: this.value,
        }
    },
    methods: {
        getValue() {
            return this.innerValue;
        },
        valueChanged() {
            if (this.innerValue != this.oldVal) {
                this.$emit('valueChanged', {
                accessor: this.accessor,
                value: this.getValue()
                });
            }
            this.oldVal = this.innerValue;
       }
    },
};
</script>
