<template>
    <v-menu :close-on-content-click="false" offset-y>
        <template v-slot:activator="{ on }">
            <v-text-field
                v-on="on"
                clearable
                single-line
                outlined
                flat
                dense
                v-model="innerValue"
                @change="valueChanged"
                @click:clear="cleared"
                append-outer-icon="mdi-calendar-month"
            >
            </v-text-field>
        </template>
        <v-date-picker
            v-model="innerValue"
            type="date"
            @change="valueChanged"
        ></v-date-picker>
    </v-menu>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig,
    methods: {
        cleared() {
            this.innerValue = null;
            this.valueChanged();
        }
    }
};
</script>
