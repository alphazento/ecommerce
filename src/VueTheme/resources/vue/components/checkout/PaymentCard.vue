<template>
  <v-form v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-radio-group v-model="radioGroup">
        <v-expansion-panels accordion hover>
          <v-expansion-panel
            class="checkout__v-expandsion-panel"
            v-for="(item,i) in appData.consts['paymentmethods']"
            :key="i"
          >
            <v-expansion-panel-header class="checkout__v-expansion-panel-header">
              <v-radio :label="item.title" :value="i"></v-radio>
              <span class="text--right">
                <v-img class="payment-method__icon" height="32px" contain :src="item.image"></v-img>
              </span>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <component :is="item.component" v-bind="item"></component>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
      </v-radio-group>
    </v-card>
  </v-form>
</template>

<style >
.checkout__v-expandsion-panel {
  border-radius: 10px !important;
  border: solid grey 2px;
  margin-bottom: 20px;
}

.checkout__v-expandsion-panel.v-expansion-panel--active {
  border: solid #1976d2 2px !important;
}

.checkout__v-expansion-panel-header.v-expansion-panel-header--active {
  border-bottom: solid #1976d2 2px;
}
.payment-method__icon {
  float: right;
  overflow: hidden;
  width: 128px;
}
</style>

<script>
import { mapGetters } from "vuex";

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
      radioGroup: -1,
      valid: false,
      nameRules: [
        v => !!v || "Name is required",
        v => (v && v.length <= 10) || "Name must be less than 10 characters"
      ],
      name: ""
    };
  },
  computed: {
    ...mapGetters(["appData"])
  },
  methods: {
    childMessage() {
      this.$emit("childMessage", this.step);
    },
    estimatePayment() {
      axios.get(this.apiUrl).then(response => {});
    }
  }
};
</script>