<template>
  <v-form v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-text-field
        v-model="businessname"
        :counter="60"
        :rules="nameRules"
        label="Business Name(Optional)"
      ></v-text-field>
      <div class="v-input theme--light v-text-field v-text-field--is-booted">
        <div class="v-input__control">
          <div class="v-input__slot">
            <div class="v-text-field__slot">
              <vue-google-autocomplete
                  id="map"
                  classname="form-control"
                  placeholder="Start typing your address..."
                  v-on:placechanged="getAddressData"
                  country="au"
              >
              </vue-google-autocomplete>
            </div>
          </div>
        </div>
      </div>
    </v-card>

    <v-btn color="primary" :disabled="!valid" @click="childMessage">Continue</v-btn>
  </v-form>
</template>

<script>
//https://github.com/olefirenko/vue-google-autocomplete#correct-usage-of-the-types-parameter
import VueGoogleAutocomplete from 'vue-google-autocomplete'
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
      address: "",
      addressRules: [
        v => !!v || "Address is required",
        v => (v && v.length <= 120) || "Name must be less than 120 characters"
      ],
      businessname: "",
      nameRules: [
        v =>
          !v || (v && v.length <= 60) ||
          "Business Name must be less than 120 characters"
      ]
    };
  },
  methods: {
    childMessage() {
      this.$emit("childMessage", this.step);
    },
    getAddressData: function (addressData, placeResultData, id) {
      this.address = addressData;
    }
  },
  components: { VueGoogleAutocomplete }
};
</script>