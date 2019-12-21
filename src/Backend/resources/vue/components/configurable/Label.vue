<template>
    <p class="title" @change="valueChanged">
        {{ innerValue }}
    </p>
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
            type: String | Number
        },
        options: {
            type: Array
        }
    },
    data() {
        return {
            oldVal: this.value,
            innerValue: this.value
        };
    },
    methods: {
        getValue() {
            return this.innerValue;
        },
        valueChanged() {
            if (this.innerValue != this.oldVal) {
                this.$emit("valueChanged", {
                    accessor: this.accessor,
                    value: this.getValue()
                });
            }
            this.oldVal = this.innerValue;
        }
    }
};
</script>
