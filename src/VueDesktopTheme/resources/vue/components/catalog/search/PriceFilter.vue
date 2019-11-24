<template>
  <v-list>
    <v-list-item>
      <v-list-item-content>
        <v-range-slider v-model="range" :max="max" :min="min" hide-details class="align-center">
          <template v-slot:prepend>
            <v-text-field
              v-model="range[0]"
              class="mt-0 pt-0"
              hide-details
              single-line
              type="number"
              style="width: 60px"
            ></v-text-field>
          </template>
          <template v-slot:append>
            <v-text-field
              v-model="range[1]"
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
  props: {},
  data() {
    return {
      min: -50,
      max: 90,
      slider: 40,
      range: [-20, 70]
    };
  },
  computed: {}
};
</script>