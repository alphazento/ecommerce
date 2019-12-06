<template>
  <full-cart-item-simple :item="item">
    <template>
      <div>
        <div v-for="(option, i) of reduced" :key=i>
          <span><strong>{{option.name}}:</strong>{{option.value}}</span>
        </div>
    </div>
    </template>
  </full-cart-item-simple>
</template>

<script>
import MiniVariation from "./MiniVariation"
export default {
  extends: MiniVariation,
};
</script>