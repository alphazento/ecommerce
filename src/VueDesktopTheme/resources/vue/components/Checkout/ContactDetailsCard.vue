<template>
  <v-form v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-text-field v-model="email" :rules="emailRules" label="Email Address" required></v-text-field>
      <v-text-field v-model="name" :counter="60" :rules="nameRules" label="Full Name" required></v-text-field>
    </v-card>
    <v-card></v-card>
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
    },
  },
  data() {
    return {
      valid: false,
      name: "",
      nameRules: [
        v => !!v || "Name is required",
        v => (v && v.length <= 60) || "Name must be less than 10 characters"
      ],
      email: "",
      emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
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