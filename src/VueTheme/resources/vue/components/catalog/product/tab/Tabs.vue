<template>
    <div>
        <v-tabs
            v-model="model"
            background-color=" accent-4"
            light
        >
            <v-tab v-for="(tab, name) in productTabs" :key="name" :href="`#product-tab-${name}`">
                {{ name }}
            </v-tab>
            <slot name="extra-tab-headers" v-bind:product="product">
            </slot>
        </v-tabs>
        <v-tabs-items v-model="model">
            <slot name="product-tab" v-bind:product="product" v-bind:tabs="productTabs">
                <v-tab-item
                    v-for="(tab, name) in productTabs" :key="name"
                    :value="`product-tab-${name}`"
                >
                    <v-list>
                        <v-list-item v-for="(item, idx) in tab" :key="idx">
                            <v-list-item-content>
                                <v-list-item-title v-text="item.label" color="primary"></v-list-item-title>
                                <hr>
                                <br/>
                                <div v-html="product[item.attribute]"></div>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-tab-item>
            </slot>
            <slot name="extra-tabs" v-bind:product="product">
            </slot>
        </v-tabs-items>
    </div>
</template>

<script>
export default {
    props: {
        product: {
            type: Object
        },
        productTabs: {
            type: Object
        }
    },
    data() {
        return {
            model: ""
        };
    }
};
</script>

