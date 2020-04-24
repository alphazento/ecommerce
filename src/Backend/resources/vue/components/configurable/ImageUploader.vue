<template>
    <v-card>
        <v-card-actions>
          <v-btn text>
            <span>{{innerValue}}</span>
            <z-file-picker 
              v-bind="{...$props, ...$attrs}"
              @fileSelected="fileSelected">
            </z-file-picker>
          </v-btn>
        </v-card-actions>
        <v-img :src="innerValue"
          :max-width="maxWidth" >
          <template v-slot:placeholder>
            <v-row class="fill-height ma-4" align="center" justify="center">
              No Image
            </v-row>
          </template>
        </v-img>
    </v-card>
</template>

<script>
import BaseConfig from "./Base";
export default {
  extends: BaseConfig,
  props: {
    maxWidth: String
  },
  methods: {
    fileSelected(item) {
      this.innerValue = item.value;
      this.valueChanged();
    }
  }
};
</script>
