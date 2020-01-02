<template>
  <v-select
    class="limit-width"
    :items="canDoOptions"
    :disabled="!canEdit"
    item-text="label"
    item-value="value"
    required
    v-model="innerValue"
    @change="valueChanged"
  >
    <template v-slot:selection="{item}">
      <v-btn width="100%" :color="item.color">{{item.label}}</v-btn>
    </template>
    <template v-slot:item="{item}">
      <v-btn width="100%" :color="item.color">{{item.label}}</v-btn>
    </template>
  </v-select>
</template>

<script>
import BaseConfig from "@Zento_Backend/components/configurable/Base";
export default {
  extends: BaseConfig,
  props: {
    extraData: {
      id: String
    }
  },
  data() {
    return {
      canEdit: true
    };
  },
  methods: {
    valueChanged() {
      axios
        .patch(
          `/api/v1/admin/sales/orders/${this.extraData.id}/status/${this.innerValue}`
        )
        .then(
          response => {
            if (!response.data.success) {
              this.innerValue = this.oldVal;
            }
          },
          err => {
            this.innerValue = this.oldVal;
          }
        );
    }
  },
  computed: {
    canDoOptions() {
      let selectedOption = this.options.find(element => {
        return element.value === this.innerValue;
      });
      if (!selectedOption || !selectedOption.next_cadidates) {
        return this.options;
      }

      let options = this.options.filter(element => {
        return selectedOption.next_cadidates.includes(element.value);
      });
      options.push(selectedOption);
      return options;
    }
  }
};
</script>
