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
      availables: [],
      priceRange: [],
      images: []
    };
  },
  created() {
    if (this.product.configurables) {
      this.availables = this.product.configurables;
    }
    this.initSwatches();
    this.calc();
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
            if (!this.swatches[swatch].items.includes(product[swatch])) {
              this.swatches[swatch].items.push(product[swatch]);
            }
          });
        });
      }
    },
    swatchCard(name) {
      switch (name) {
        case "color":
          return "product-color-swatch";
          break;
        case "size":
          return "product-size-selector";
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
      // reduced.sort((a, b) => (a.prices.price > b.prices.price ? 1 : -1));
      this.availables = reduced;
    },
    calc() {
      var images = this.availables.map(v => {
        return v.media_gallery;
      });
      images = images.reduce((accumulator, currentValue) => {
        return accumulator.concat(currentValue);
      }, []);

      images = images.filter((value, index, self) => {
        return self.indexOf(value) === index;
      });

      this.images = images.map(jsontext => {
        var item = JSON.parse(jsontext);
        item.image = item.value;
        return item;
      });

      this.availables.sort((a, b) =>
        a.prices.price > b.prices.price ? 1 : -1
      );
      let priceFrom = this.availables[0].prices.price;
      let priceTo = this.availables[this.availables.length - 1].prices.price;
      this.priceRange = [priceFrom];
      if (priceTo > priceFrom) {
        this.priceRange.push(priceTo);
      }
      this.$emit("productElementsUpdated", {
        images: this.images,
        priceRange: this.priceRange,
        candidates: this.availables
      });
    },
    swatchSelected(item) {
      this.swatches[item.swatch].current = item.value;
      this.reduceResouces();
      this.calc();
    }
  }
};
</script>
