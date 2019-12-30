<template>
    <v-menu :close-on-content-click="false" offset-y >
        <template v-slot:activator="{ on }">
            <v-text-field
                v-on="on"
                single-line
                outlined
                flat
                dense
                v-model="innerValue"
                @change="valueChanged"
                append-outer-icon="mdi-calendar-month"
            >
            </v-text-field>
        </template>
        <v-date-picker
            v-model="innerValue"
            type="date"
        ></v-date-picker>
    </v-menu>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig,
    mounted() {
        if (!this.innerValue) {
            this.innerValue = new Date().toISOString().substr(0, 10);
        }
    }
};
</script>
