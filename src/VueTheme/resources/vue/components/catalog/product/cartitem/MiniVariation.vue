<template>
  <mini-cart-item-simple :item="item" :product-image="product_image" :product-url="product_url">
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
  </mini-cart-item-simple>
</template>

<script>
var mixin = require("./variation_mix");
import MiniSimple from "./MiniSimple";
export default {
  mixins: [mixin.default],
  extends: MiniSimple
};
</script>
