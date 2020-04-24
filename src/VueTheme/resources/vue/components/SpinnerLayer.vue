<template>
  <div>
    <v-overlay
      :absolute="spinnerOverlay.absolute"
      :opacity="spinnerOverlay.opacity"
      :value="spinnerOverlay.overlay"
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
      <div class="text-center ma-12">{{ spinnerOverlay.text }}</div>
    </v-overlay>

    <v-snackbar :timeout="timeout" v-model="snackBar" multi-line top vertical>
      {{ spinnerOverlay.text }}
      <v-btn dark text @click="snackBar = false">Close</v-btn>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  data: () => ({
    indeterminate: true,
    size: 96,
    width: 4,
    timeout: 4000
  }),
  computed: {
    spinnerOverlay() {
      return this.$store.state.spinnerOverlay;
    },
    snackBar: {
      get() {
        return this.$store.state.spinnerOverlay.snack;
      },
      set(value) {
        let obj = this.spinnerOverlay;
        obj.snack = value;
        this.$store.commit("controlSpinnerLayer", obj);
      }
    }
  }
};
</script>
