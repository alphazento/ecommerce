<template>
  <form ref="checkout_braintree_form">
    <v-card color="lighten-1" class="mb-12" flat>
      <v-container>
        <v-layout row>
          <v-flex md12>
            <div class="braintree-hostfield">
              <label>Credit Card Number</label>
              <div class="braintree__element braintree__card_number"></div>
              <div class="v-text-field__details" v-if="errors.number">
                <div class="v-messages theme--light error--text" role="alert">
                  <div class="v-messages__wrapper">
                    <div class="v-messages__message">Credit Card Number Is Invalid</div>
                  </div>
                </div>
              </div>
            </div>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex md12>
            <div class="braintree-hostfield">
              <label>Expire Date</label>
              <div class="braintree__element braintree__expire_date"></div>
              <div class="v-text-field__details" v-if="errors.expirationDate">
                <div class="v-messages theme--light error--text" role="alert">
                  <div class="v-messages__wrapper">
                    <div class="v-messages__message">Expiration Date Is Invalid</div>
                  </div>
                </div>
              </div>
            </div>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex md12>
            <div class="braintree-hostfield">
              <label>CVV</label>
              <div class="braintree__element braintree__cvv"></div>
              <div class="v-text-field__details" v-if="errors.cvv">
                <div class="v-messages theme--light error--text" role="alert">
                  <div class="v-messages__wrapper">
                    <div class="v-messages__message">CVV Is Invalid</div>
                  </div>
                </div>
              </div>
            </div>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>
    <v-btn color="primary" @click="placeOrder">Place Order</v-btn>
  </form>
</template>

<script>
import braintree from "braintree-web";
import { mapGetters } from "vuex";

export default {
  props: {
    configs: {
      type: Object
    }
  },
  data() {
    return {
      hostedFieldInstance: null,
      errors: { cvv: false, number: false, expirationDate: false },
      nonce: "",
      niceType: "Visa/Master",
      cvvAlias: "CVV"
    };
  },
  created() {
    // this.$store.registerModule("FETCH_BRAINTREE_CLIENT_TOKEN", state);
    this.prepare();
  },
  methods: {
    placeOrder() {
      this.hostedFieldInstance.tokenize({}, (tokenizeErr, payload) => {
        if (tokenizeErr) {
          console.error("tokenizeErr", tokenizeErr);
          this.parseTokenizeErr(tokenizeErr);
          this.nonce = "";
        } else {
          this.errors = { cvv: false, number: false, expirationDate: false };
          this.nonce = payload.nonce;
          this.$store.dispatch("SHOW_SPINNER", "Submit your order...");
          axios
            .post("/api/v1/payment/capture/braintree", {
              version: "v1",
              quote: this.quote,
              payment: { nonce: this.nonce }
            })
            .then(response => {
              if (response.success) {
                this.$store
                  .dispatch(
                    "PLACE_ORDER_REQUEST",
                    response.data.payment_transaction.pay_id
                  )
                  .then(response => {
                    this.$store.dispatch("HIDE_SPINNER");
                    window.location.href = "/checkout/success";
                  });
              }
            });
        }
      });
    },
    fetchToken() {
      return new Promise((resolve, reject) => {
        this.$store.dispatch("SHOW_SPINNER", "Loading...");
        axios.get("/api/v1/braintree/token").then(
          response => {
            if (response && response.success) {
              this.$store.dispatch("HIDE_SPINNER");
              resolve(response);
            } else {
              this.$store.dispatch(
                "SNACK_MESSAGE",
                "Can not init this payment method"
              );
              reject(response);
            }
          },
          error => {
            this.$store.dispatch("HIDE_SPINNER");
            this.$store.dispatch(
              "SNACK_MESSAGE",
              "Can not init this payment method"
            );
            reject(error);
          }
        );
      });
    },
    prepare() {
      this.fetchToken().then(response => {
        braintree.client
          .create({
            authorization: response.data.token
          })
          .then(clientInstance => {
            let options = {
              client: clientInstance,
              styles: {
                input: {
                  "font-size": "14px"
                },
                "input::placeholder": {
                  color: "#A5A5A5"
                },
                "input.invalid": {
                  color: "red"
                },
                "input.valid": {
                  color: "green"
                }
              },
              fields: {
                number: {
                  selector: ".braintree__card_number",
                  placeholder: "Enter Credit Card"
                },
                cvv: {
                  selector: ".braintree__cvv",
                  placeholder: "Enter CVV"
                },
                expirationDate: {
                  selector: ".braintree__expire_date",
                  placeholder: "00 / 0000"
                }
              }
            };
            return braintree.hostedFields.create(options);
          })
          .then(hostedFieldInstance => {
            this.hostedFieldInstance = hostedFieldInstance;
            this.hostedFieldInstance.on("focus", e => {
              this.errors[e.emittedBy] = false;
            });
            this.hostedFieldInstance.on("cardTypeChange", e => {
              console.log("input cardTypeChange", e);
              if (e.cards && e.cards[0]) {
                this.niceType = e.cards[0].niceType;
                this.cvvAlias = e.cards[0].code.name;
              }
              console.log("nicetype:", this.niceType, this.cvvAlias);
            });
          });
      });
    },
    parseTokenizeErr(tokenizeErr) {
      switch (tokenizeErr.code) {
        case "HOSTED_FIELDS_FIELDS_EMPTY":
          this.errors = { cvv: true, number: true, expirationDate: true };
          break;
        case "HOSTED_FIELDS_FIELDS_INVALID":
          tokenizeErr.details.invalidFieldKeys.forEach(v => {
            this.errors[v] = true;
          });
          break;
      }
    }
  },
  computed: {
    ...mapGetters(["quote"])
  }
};
</script>

<style lang="scss" scoped>
.braintree-hostfield {
  margin-bottom: 10px;
  label {
    letter-spacing: 0.05em;
    margin-bottom: 0.15em;
    color: #646464;
    font-size: 12px;
  }
}

.braintree__element {
  height: 42px;
  border: 1px solid #e6e6e6;
  font-size: 16px;
  padding: 10px 1rem 10px 1rem;
  background-color: white;
  outline: 0;
}
</style>
