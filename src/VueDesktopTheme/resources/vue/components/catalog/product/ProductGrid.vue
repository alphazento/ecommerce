<template>
    <v-container fluid>
        <v-layout row>
            <v-flex
                v-for="(item, index) in dataset.data"
                :key="index"
                :class="layout_flex"
            >
                <component
                    :is="productCard(item)"
                    v-bind="{ product: item }"
                ></component>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    name: "imageslider",
    props: {
        dataset: {
            type: Object
        },
        gerneralMode: {
            type: Boolean
        },
        flex: {
            type: String
        }
    },
    created() {
        this.layout_flex = this.flex ? this.flex : "md3 xs6";
    },
    methods: {
        productCard(product) {
            if (this.gerneralMode) {
                return "general-product-card";
            }
            switch (product.type_id) {
                case "simple":
                case "downloadable":
                default:
                    return "simple-product-card";
                    break;
            }
        }
        // navPage(page) {
        //   axios.get(this.apiUrl + "?page=" + page).then(response => {
        //     this.pagiData = response.data.data.products;
        //   });
        // }
    }
};
</script>
