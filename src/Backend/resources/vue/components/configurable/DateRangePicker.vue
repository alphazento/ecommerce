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
    methods: {
        fromDateChanged(date) {
            this.innerValue[0] = date.value;
            this.datesChanged();
        },
        toDateChanged(date) {
            this.innerValue[1] = date.value;
            this.datesChanged();
        },
        datesChanged() {
            let value = this.innerValue;
            if (!this.innerValue[0] && !this.innerValue[1]) {
                value = null;
            }
            this.$emit("valueChanged", {
                accessor: this.accessor,
                value: value
            });
        }
    },
    created() {
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
    },
    watch: {
        value(nV, oV) {
            if (nV) {
                this.innerValue = nV;
            } else {
                this.innerValue = ["", ""];
            }
        }
    }
};
</script>

<style scoped>
.dense-margin {
    margin-top: -20px;
    margin-bottom: -20px;
}
</style>
