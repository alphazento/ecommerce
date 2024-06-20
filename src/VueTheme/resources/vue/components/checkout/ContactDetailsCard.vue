<template>
  <v-form ref="checkout_user_form" v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-card-text>
        <v-text-field v-model="guest.email" :rules="emailRules" label="Email Address" required></v-text-field>
        <v-text-field
          v-model="guest.name"
          :counter="60"
          :rules="nameRules"
          label="Full Name"
          required
        ></v-text-field>
      </v-card-text>
      <v-card-actions class="container">
        <v-btn style="width:100%" color="primary" :disabled="!valid" @click="childMessage">Continue</v-btn>
      </v-card-actions>
      <slot></slot>
    </v-card>
    <v-card></v-card>
  </v-form>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    step: {
      type: Number,
    },
    complete: {
      type: Boolean,
    },
  },
  data() {
    return {
      guest: {},
      valid: false,
      nameRules: [
        (v) => !!v || "Name is required",
        (v) => (v && v.length <= 60) || "Name must be less than 10 characters",
      ],
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
    };
  },
  created() {
    this.guest = Object.assign({}, this.customer);
  },
  computed: {
    ...mapGetters(["customer"]),
  },
  methods: {
    childMessage() {
      if (this.$refs.checkout_user_form.validate()) {
        this.$store
          .dispatch("CHECKOUT_AS_GUEST_CUSTOMER", this.guest)
          .then((response) => {
            this.$emit("childMessage", this.step);
          });
      }
    },
  },
  watch: {
    customer() {
      this.guest = Object.assign({}, this.customer);
    },
  },
};
</script>
