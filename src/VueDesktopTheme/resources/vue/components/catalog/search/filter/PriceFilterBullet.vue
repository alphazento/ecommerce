<template>
  <v-list>
    <v-list-item>
      <v-range-slider
        v-model="range"
        :max="max"
        :min="min"
        thumb-label="always"
        hide-details
        class="align-center"
      >
        <template v-slot:prepend>
          <v-btn text style="width: 40px">{{min}}</v-btn>
        </template>
        <template v-slot:append>
          <v-btn text style="width: 40px">{{max}}</v-btn>
        </template>
      </v-range-slider>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  props: {
    items: {
      type: Array
    },
    applied: {
      type: Array
    }
  },
  data() {
    return {
      min: this.items[0],
      max: this.items[1],
      slider: 100,
      range: this.items
    };
  },
  computed: {}
};
</script>