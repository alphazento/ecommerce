<template>
  <div>
    <product-variations-block
      :product="product"
      @productElementsUpdated="productElementsUpdated"
      :rules="[rules.required]"
    ></product-variations-block>
    <v-container class="no-v-padding">
      <v-input
        v-model="actual_pid"
        type="hidden"
        readonly
        :rules="[rules.required]"
      />
      <input name="options[actual_pid]" type="hidden" v-model="actual_pid" />
    </v-container>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
    },
  },
  data() {
    return {
      variationElements: {
        images: [],
        priceRange: [this.product.price.final_price],
        candidates: [],
      },
      actual_pid: 0,
      rules: {
        required: (value) => !!value || "Please select product option.",
      },
    };
  },
  methods: {
    productElementsUpdated(elements) {
      this.variationElements = elements;
      if (this.variationElements.candidates.length == 1) {
        this.actual_pid = this.variationElements.candidates[0].id;
      } else {
        this.actual_pid = 0;
      }

      var price = elements.priceRange[0];
      if (elements.priceRange.length > 1) {
        price = `${price}-$${elements.priceRange[1]}`;
      }

      this.$emit("update_images", elements.images);
      this.$emit("update_price", price);
    },
  },
};
</script>
