<template>
    <div>
        <config-date-item
            accessor="fromDate"
            :value="innerValue[0]"
            @valueChanged="fromDateChanged"
        ></config-date-item>
        <div class="dense-margin">
            <config-date-item
                accessor="toDate"
                :value="innerValue[1]"
                @valueChanged="toDateChanged"
            ></config-date-item>
        </div>
    </div>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig,
    data() {
        return {
            innerValue: ["", ""]
        };
    },
    methods: {
        fromDateChanged(date) {
            this.innerValue[0] = date.value;
            this.$emit("valueChanged", {
                accessor: this.accessor,
                value: this.innerValue
            });
        },
        toDateChanged(date) {
            this.innerValue[1] = date.value;
            this.$emit("valueChanged", {
                accessor: this.accessor,
                value: this.innerValue
            });
        }
    },
    mounted() {
        if (!Array.isArray(this.innerValue)) {
            this.innerValue = ["", ""];
        }
        if (this.innerValue.length < 2) {
            let date = new Date().toISOString().substr(0, 10);
            this.innerValue.push(date);
            if (this.innerValue.length < 2) {
                this.innerValue.push(date);
            }
        }
        console.log("date range", this.innerValue);
    }
};
</script>

<style scoped>
.dense-margin {
    margin-top: -20px;
    margin-bottom: -20px;
}
</style>
