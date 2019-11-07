<template>
  <v-form v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-text-field
        v-model="businessname"
        :counter="60"
        :rules="nameRules"
        label="Business Name(Optional)"
      ></v-text-field>
      <v-text-field
        v-model="address"
        :counter="300"
        :rules="nameRules"
        label="Start typing your address..."
        required
      ></v-text-field>
    </v-card>
    <v-btn color="primary" :disabled="!valid" @click="childMessage">Continue</v-btn>
  </v-form>
</template>

<script>
export default {
  props: {
    step: {
      type: Number
    },
    complete: {
      type: Boolean
    }
  },
  data() {
    return {
      valid: false,
      address: "",
      addressRules: [
        v => !!v || "Address is required",
        v => (v && v.length <= 120) || "Name must be less than 120 characters"
      ],
      businessname: "",
      nameRules: [
        v =>
          !v || (v && v.length <= 60) ||
          "Business Name must be less than 120 characters"
      ]
    };
  },
  methods: {
    childMessage() {
      this.$emit("childMessage", this.step);
    }
  }
};
</script>