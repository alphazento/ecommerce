<template>
  <div>
    <v-overlay
      :absolute="spinnerCtl.absolute"
      :opacity="spinnerCtl.opacity"
      :value="spinnerCtl.overlay"
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
      <div class="text-center ma-12">{{ spinnerCtl.text }}</div>
    </v-overlay>

    <v-snackbar :timeout="timeout" v-model="snackBar" multi-line top vertical>
      {{ spinnerCtl.text }}
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
    ...mapGetters(["spinnerCtl"]),
    snackBar: {
      get() {
        return this.spinnerCtl.snack_bar;
      },
      set(value) {
        this.$store.commit("HIDE_SNACK");
      }
    }
  }
};
</script>
