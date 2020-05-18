<template>
  <v-form v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-expansion-panels accordion>
        <v-expansion-panel v-for="(item,i) in appData.consts['paymentmethods']" :key="i">
          <v-expansion-panel-header text-left>
            <span>
              <v-img
                :width="item.image.width"
                :height="item.image.height"
                contain
                :src="item.image.src"
              ></v-img>
            </span>
            <span>{{item.title}}</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <component :is="item.component" v-bind="item"></component>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
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
      nameRules: [
        v => !!v || "Name is required",
        v => (v && v.length <= 10) || "Name must be less than 10 characters"
      ],
      name: ""
    };
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