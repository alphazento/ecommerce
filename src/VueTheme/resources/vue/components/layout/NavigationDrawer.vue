<template>
  <v-list dense nav>
    <v-list-item>
      <v-list-item-avatar>
        <v-icon color="grey">mdi-account</v-icon>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title>
          <a v-if="isGuest" @click="signin($event)" href="/login">Login</a>
          <a v-else href="/my-account">Account</a>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item v-if="!isGuest">
      <v-list-item-content>
        <v-list-item-title>
          <a href="/my-account/orders">Orders</a>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item v-if="!isGuest">
      <v-list-item-content>
        <v-list-item-title>
          <a href="/my-account/by-again">Buy Again</a>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-divider></v-divider>
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title>
          <a href="/">Home</a>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <slot></slot>
  </v-list>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters(["customer", "isGuest"])
  },
  methods: {
    signin(event) {
      event && event.preventDefault();
      this.$emit("signin");
    }
  }
};
</script>
