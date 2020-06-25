<template>
  <v-container>
    <component
      v-for="(attr, name) in attrs"
      :key="name"
      :is="attrContainerComponent(name)"
      v-bind="attr"
      @containerSelected="containerSelected"
    ></component>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    product: {
      type: Object,
    },
  },

  data() {
    return {
      attrs: {},
      products: {},
      availables: [],
      priceRange: [],
      images: [],
    };
  },
  created() {
    if (this.product.configurables && this.product.configurables.length > 0) {
      this.availables = this.product.configurables;
    }
    this.initAttrs();
    this.calc();
  },
  computed: {
    ...mapGetters(["attrContainers"]),
  },
  methods: {
    //init attrs which use container
    initAttrs() {
      let keys = Object.keys(this.attrContainers);
      if (keys.length > 0 && this.availables) {
        keys.forEach((key) => {
          this.attrs[key] = {
            type: key,
            items: [],
            current: null,
          };
          this.products[key] = [];
          this.product.configurables.forEach((product) => {
            this.products[key].push(product);
            if (!this.attrs[key].items.includes(product[key])) {
              this.attrs[key].items.push(product[key]);
            }
          });
        });
      }
    },
    attrContainerComponent(name) {
      switch (name) {
        case "color":
          return "z-product-color-container";
          break;
        case "size":
          return "z-product-size-container";
          break;
      }
    },
    reduceResouces() {
      var reduced = this.product.configurables;
      Object.keys(this.attrContainers).forEach((key) => {
        var attr = this.attrs[key];
        if (attr.current && attr.current !== undefined) {
          reduced = reduced.filter((product) => {
            return product[attr.type] === attr.current;
          });
        }
      });
      // reduced.sort((a, b) => (a.price.final_price > b.price.final_price ? 1 : -1));
      this.availables = reduced;
    },
    calc() {
      this.availables = this.availables.map((product) => product);
      var images = this.availables.map((v) => {
        return v.media_gallery;
      });
      images = images.reduce((accumulator, currentValue) => {
        return accumulator.concat(currentValue);
      }, []);

      images = images.filter((value, index, self) => {
        return self.indexOf(value) === index;
      });

      this.images = images.map((jsontext) => {
        var item = JSON.parse(jsontext);
        item.image = item.value;
        return item;
      });

      this.availables.sort((a, b) =>
        a.price.final_price > b.price.final_price ? 1 : -1
      );

      let priceFrom = this.availables[0].price.final_price;
      let priceTo = this.availables[this.availables.length - 1].price
        .final_price;
      this.priceRange = [priceFrom];
      if (priceTo > priceFrom) {
        this.priceRange.push(priceTo);
      }
      this.$emit("productElementsUpdated", {
        images: this.images,
        priceRange: this.priceRange,
        candidates: this.availables,
      });
    },
    containerSelected(item) {
      this.$store.dispatch("SELECT_ATTR_CONTAINER", item);
      this.reduceResouces();
      this.calc();
    },
  },
};
</script>
