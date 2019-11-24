<template>
  <v-list>
    <v-list-item>
      <v-list-item-content>
        <v-range-slider v-model="vrange" :max="max" :min="min" hide-details class="align-center">
          <template v-slot:prepend>
            <v-text-field
              v-model="vrange[0]"
              class="mt-0 pt-0"
              hide-details
              single-line
              type="number"
              style="width: 60px"
            ></v-text-field>
          </template>
          <template v-slot:append>
            <v-text-field
              v-model="vrange[1]"
              class="mt-0 pt-0"
              hide-details
              single-line
              type="number"
              style="width: 60px"
            ></v-text-field>
          </template>
        </v-range-slider>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  props: {
    range: {
      type: Array
    }
  },
  data() {
    return {
      min: this.range[0],
      max: this.range[1],
      slider: 100,
      vrange: this.range
    };
  },
  computed: {}
};
</script>