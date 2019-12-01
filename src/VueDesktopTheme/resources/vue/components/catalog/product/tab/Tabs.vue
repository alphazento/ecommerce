<template>
    <v-layout row>
        <v-tabs
            v-model="model"
            background-color=" accent-4"
            center-active
            centered
            dark
        >
            <v-tab v-for="(tab, idx) in tabs" :key="idx" :href="`#tab-${idx}`"
                >{{ tab }}
            </v-tab>
        </v-tabs>
        <v-tabs-items v-model="model">
            <v-tab-item
                v-for="(tab, idx) in tabs"
                :key="idx"
                :value="`tab-${idx}`"
            >
                <product-tab
                    :description="product[idx]"
                    :flex="'md12 xs12'"
                ></product-tab>
            </v-tab-item>
        </v-tabs-items>
    </v-layout>
</template>

<script>
var mixin = require("../../../../mixin/catalogpollyfill");
export default {
    mixins: [mixin.default],
    props: {
        product: {
            type: Object
        },
        tabs: {
            type: Object
        }
    },
    data() {
        return {
            selectedQty: 1,
            qtys: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            model: "tab-physic"
        };
    }
};
</script>

<style scoped>
.btn__addtocart {
    color: #fff;
    background-color: #600bd2 !important;
    margin: 5px 5px;
}
</style>
