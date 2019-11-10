<template>
  <v-form v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-expansion-panels accordion>
        <v-expansion-panel v-for="(item,i) in 1" :key="i">
          <v-expansion-panel-header>
            <v-layout>
              <v-flex md2>
                <v-img
                  width="56px"
                  height="56px"
                  contain
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAA4CAIAAAAn5KxJAAAACXBIWXMAAAsTAAALEwEAmpwYAAAG0mlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDUgNzkuMTYzNDk5LCAyMDE4LzA4LzEzLTE2OjQwOjIyICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoTWFjaW50b3NoKSIgeG1wOkNyZWF0ZURhdGU9IjIwMTgtMTItMTlUMTE6NDY6MjQrMTE6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDE5LTAxLTA5VDEwOjI0OjQxKzExOjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDE5LTAxLTA5VDEwOjI0OjQxKzExOjAwIiBkYzpmb3JtYXQ9ImltYWdlL3BuZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgcGhvdG9zaG9wOklDQ1Byb2ZpbGU9InNSR0IgSUVDNjE5NjYtMi4xIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjRmMzI4MDViLTQ5NDktNDMwNS1hMmZiLWI4MTFkY2NjYjE2NSIgeG1wTU06RG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOmE0ZWFmMTM2LWU2N2QtMmY0NS1hOTQ5LTNlNWE5MTI4NWRiMCIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjBkYjU5YjFlLWVhZDAtNGYxMS05ODJhLWZiM2FiMjA0MjU5NSI+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNyZWF0ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6MGRiNTliMWUtZWFkMC00ZjExLTk4MmEtZmIzYWIyMDQyNTk1IiBzdEV2dDp3aGVuPSIyMDE4LTEyLTE5VDExOjQ2OjI0KzExOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoTWFjaW50b3NoKSIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6NjJhNDA2YmMtYzcwNS00MDVjLTkwZTUtZjEwMjRiY2ZkZDRlIiBzdEV2dDp3aGVuPSIyMDE5LTAxLTA5VDEwOjI0OjI3KzExOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6NGYzMjgwNWItNDk0OS00MzA1LWEyZmItYjgxMWRjY2NiMTY1IiBzdEV2dDp3aGVuPSIyMDE5LTAxLTA5VDEwOjI0OjQxKzExOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBl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"
                ></v-img>Paypal
              </v-flex>
            </v-layout>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <paypal-card></paypal-card>
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
  }
};
</script>