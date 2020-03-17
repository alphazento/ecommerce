<template>
  <div>
    <v-overlay
      :absolute="spinnerParameters.absolute"
      :opacity="spinnerParameters.opacity"
      :value="spinnerParameters.overlay"
      z-index="99999"
    >
      <div class="text-center ma-12">
        <v-progress-circular
          :indeterminate="indeterminate"
          :size="size"
          :width="width"
          color="light-blue"
        ></v-progress-circular>
      </div>
      <div class="text-center ma-12">{{ spinnerParameters.text }}</div>
    </v-overlay>

    <v-snackbar :timeout="timeout" v-model="snackBar" multi-line top vertical>
      {{ spinnerParameters.text }}
      <v-btn dark text @click="snackBar = false">Close</v-btn>
    </v-snackbar>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    indeterminate: true,
    size: 96,
    width: 4,
    timeout: 4000
  }),
  computed: {
    ...mapGetters(["spinnerParameters"]),
    snackBar: {
      get() {
        return this.spinnerParameters.snack;
      },
      set(value) {
        let obj = spinnerParameters;
        obj.snack = value;
        this.$store.commit("controlSpinnerLayer", obj);
      }
    }
  }
};
</script>
