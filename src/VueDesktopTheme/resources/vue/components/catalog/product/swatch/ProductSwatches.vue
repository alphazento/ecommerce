<template>
    <v-container>
        <component
            v-for="(swatch, name) in swatches"
            :key="name"
            :is="swatchCard(name)"
            v-bind="swatch"
            @swatchSelected="swatchSelected"
        ></component>
    </v-container>
</template>

<script>
export default {
    props: {
        product: {
            type: Object
        }
    },

    data() {
        return {
            swatches: {},
            products: {},
            availables: []
        };
    },
    created() {
        this.availables = this.product.configurables;
        this.initSwatches();
    },
    computed: {
        swatchConsts() {
            return this.$store.state.swatches;
        }
    },
    methods: {
        initSwatches() {
            let keys = Object.keys(this.swatchConsts);
            if (keys.length > 0 && this.availables) {
                keys.forEach(swatch => {
                    this.swatches[swatch] = {
                        type: swatch,
                        items: [],
                        current: null
                    };
                    this.products[swatch] = [];
                    this.product.configurables.forEach(product => {
                        this.products[swatch].push(product);
                        if (
                            !this.swatches[swatch].items.includes(
                                product[swatch]
                            )
                        ) {
                            this.swatches[swatch].items.push(product[swatch]);
                        }
                    });
                });
            }
        },
        swatchCard(name) {
            switch (name) {
                case "color":
                    return "product-color-swatch-card";
                    break;
                case "size":
                    return "product-color-swatch-card";
                    break;
            }
        },
        reduceResouces() {
            var reduced = this.product.configurables;
            Object.keys(this.swatchConsts).forEach(key => {
                var swatch = this.swatches[key];
                if (swatch.current && swatch.current !== undefined) {
                    reduced = reduced.filter(product => {
                        return product[swatch.type] === swatch.current;
                    });
                }
            });
            this.availables = reduced;
            console.log("filters result ", this.availables);
        },
        swatchSelected(item) {
            this.swatches[item.swatch].current = item.value;
            this.reduceResouces();
        }
    }
};
</script>
