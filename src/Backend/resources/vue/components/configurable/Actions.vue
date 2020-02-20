<template>
    <v-menu
      close-on-click
    >
      <template v-slot:activator="{ on }">
        <v-btn
          color="primary"
          dark
          v-on="on"
        >
          Actions
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="(item, index) in options"
          :key="index"
          @click="emitAction(item.value)"
        >
          <v-list-item-title>{{ item.label }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
</template>

<script>
import BaseConfig from "./Base";
    //   :close-on-content-click="closeOnContentClick"
export default {
    extends: BaseConfig,
    methods: {
        emitAction(action) {
            this.$emit('proxyEvent', {
                action: action, data:this.extraData
            })
        }
    }
};
</script>
