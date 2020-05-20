<template>
  <v-breadcrumbs :items="breadCrumbItems" :divider="divider">
    <template v-slot:item="props">
      <router-link
        :to="props.item.href"
        :class="[props.item.disabled && 'disabled']"
      >{{ props.item.text }}</router-link>
    </template>
  </v-breadcrumbs>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    divider: {
      type: String
    }
  },

  computed: {
    ...mapGetters(["breadCrumbItems"])
  }
};
</script>
