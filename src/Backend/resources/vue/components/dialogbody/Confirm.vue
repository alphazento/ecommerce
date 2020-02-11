<template>
  <v-card>
    <v-card-title class="headline primary text-white">Confirm to Proceed</v-card-title>
    <v-card-text class="headline font-weight-bold text-center" v-html="title"></v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="green darken-1" text @click="closeDialog(false)">Cancel</v-btn>
      <v-btn color="error darken-1" text @click="closeDialog(true)">Proceed</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props: {
    title: String,
    passData: Object
  },
  methods: {
    closeDialog(success) {
      eventBus.$emit("closeDialog");
      this.$emit("close", {
        success: success,
        data: this.passData
      });
    }
  }
};
</script>
