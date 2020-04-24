<template>
  <v-card>
    <v-card-title class="headline">Refund To Customer</v-card-title>
    <v-card-subtitle>Order:</v-card-subtitle>

    <v-card-text>
      <v-form ref="admin_refund_form" v-model="valid" lazy-validation></v-form>
    </v-card-text>

    <v-card-actions>
      <v-spacer></v-spacer>

      <v-btn color="green darken-1" text @click="closeDialog(false)">Disard</v-btn>
      <v-btn color="green darken-1" text :disabled="!valid" @click="closeDialog(true)">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props: {
    title: String
  },
  data() {
    return {
      valid: false,
      comment: "",
      notifyCustomer: false,
      rules: [
        v => !!v || "Comment is required",
        v =>
          (v && v.length <= 240) || "Comment must be less than 240 characters"
      ]
    };
  },
  methods: {
    closeDialog(success) {
      if (success) {
        if (!this.$refs.admin_comment_form.validate()) {
          return;
        }
      }

      eventBus.$emit("closeDialog");
      this.$emit("close", {
        success: success,
        comment: this.comment,
        notifyCustomer: this.notifyCustomer
      });
    }
  }
};
</script>
