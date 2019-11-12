<template>
  <v-form v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-expansion-panels accordion>
        <v-expansion-panel v-for="(item,i) in consts['paymentmethods']" :key="i">
          <v-expansion-panel-header>
            <v-layout>
              <v-flex md2>
                <v-img
                  width="56px"
                  height="56px"
                  contain
                  :src="item.image"></v-img>
                {{item.title}}
              </v-flex>
            </v-layout>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <paypal-card :configs="item"></paypal-card>
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
      axios.get(this.apiUrl + "?page=" + page).then(response => {
        this.pagiData = response.data.data.products;
      });

      return HttpClient.withMessage("Estimating Payment...")
        .post("/payment/estimate", {
          cart: ShoppingCartAgent.getReducedCartData(),
          shipping_address: address
        })
        .then(resp => {
          if (resp.status === 200) {
            this.paymentMethods.apply(resp.data);
            this.estimatingIndicator().value(false);
          }
        });
    }
  },
  computed: {
    consts() {
      console.log("consts", this.$store.state.consts);
      return this.$store.state.consts;
    }
  }
};
</script>