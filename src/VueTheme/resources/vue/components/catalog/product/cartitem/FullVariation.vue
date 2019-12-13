<template>
  <full-cart-item-simple
    :item="item"
    :product-image="product_image"
    :product-url="product_url"
    @quantityChange="quantityChange"
  >
    <template>
      <div>
        <div v-for="(option, i) of reduced" :key="i">
          <span>
            <strong class="text-uppercase">{{ option.name }}:</strong>
            {{ option.value }}
          </span>
        </div>
      </div>
    </template>
  </full-cart-item-simple>
</template>

<script>
var mixin = require("./variation_mix");
import MiniVariation from "./MiniVariation";
export default {
  extends: MiniVariation,
  mixins: [mixin.default],
  methods: {
    quantityChange() {
      this.$emit("quantityChange", this.item);
    }
  }
};
</script>
