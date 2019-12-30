<template>
   <div>
       <config-date-item accessor="fromDate" :value="from" ></config-date-item>
       <div class="dense-margin" >
        <config-date-item accessor="toDate" :value="to"></config-date-item>
       </div>
   </div>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig,
    data() {
        return {
            from: "",
            to: ""
        };
    },
    mounted() {
        if (!Array.isArray(this.innerValue)) {
            this.innerValue = [];
        }
        if (this.innerValue.length < 2) {
            let date =  new Date().toISOString().substr(0, 10);
            this.innerValue.push(date);
            if (this.innerValue.length < 2) {
                this.innerValue.push(date);
            }
        }
    },
};
</script>

<style scoped>
.dense-margin {
    margin-top: -20px;
    margin-bottom: -20px;
}
</style>
