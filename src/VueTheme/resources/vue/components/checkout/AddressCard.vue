<template>
  <v-form ref="checkout_address_form" v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-container>
        <v-layout row>
          <v-flex md6 xs12>
            <v-text-field
              v-model="addressData.name"
              label="Receiver Full Name"
              @change="addressChanged"
            ></v-text-field>
          </v-flex>

          <v-flex md6 xs12>
            <v-text-field
              v-model="addressData.phone"
              label="Receiver Phone Number"
              @change="addressChanged"
            ></v-text-field>
          </v-flex>

          <v-flex md6 xs12>
            <google-address-autocomplete
                id="map"
                classname="form-control"
                placeholder="Start typing your address..."
                v-on:placechanged="getAddressData"
                country="au"
                :address="addressText"
                :rules="addressRules"
            >
            </google-address-autocomplete>
          </v-flex>

          <v-flex md6 xs12>
            <v-text-field
              v-model="addressData.company"
              :rules="nameRules"
              label="Company Name(Optional)"
              @change="addressChanged"
            ></v-text-field>
          </v-flex>

        </v-layout>
      </v-container>
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
    },
    fullname: {
      type: String
    },
    address: {
      type: Object
    }
  },

  data() {
    return {
      addressData: this.address ? this.address : {
        name: this.fullname ? this.fullname : '',
        company: '',
        address1: '',
        address2: '',
        city: '',
        country: '',
        postal_code: '',
        state: '',
        phone: ''
      },
      dataChanged: false,
      valid: false,
      addressRules: [
        v => !!v || "Address is required"
      ],
      nameRules: [
        v =>
          !v || (v && v.length <= 255) ||
          "Company Name must be less than 255 characters"
      ]
    };
  },

  methods: {
    childMessage() {
      if (this.$refs.checkout_address_form.validate()) {
        if (this.dataChanged) {
          this.$store.dispatch('setShippingAddress',  this.addressData).then(response => {
            this.$emit("childMessage", this.step);
          }, error => {
              console.error("Got nothing from server. Prompt user to check internet connection and try again")
          })
        } else {
          this.$emit("childMessage", this.step);
        }
      }
    },
    addressChanged() {
      this.dataChanged = true;
    },
    getAddressData(googleAddress, placeResultData, id) {
      this.convertGoogleAddressToAddress(googleAddress);
      this.addressChanged = true;
    },
    convertGoogleAddressToAddress(googleAddress) {
      this.addressData.city = googleAddress.locality;
      this.addressData.state = googleAddress.administrative_area_level_1;
      // address.statel2 = googleAddress.administrative_area_level_2;
      this.addressData.country = googleAddress.country;
      this.addressData.latitude = googleAddress.latitude;
      this.addressData.longitude = googleAddress.longitude;
      this.addressData.postal_code = googleAddress.postal_code;
      this.addressData.address1 = googleAddress.street_number;
      this.addressData.address2 = googleAddress.route;
    }
  },

  computed: {
    addressText() {
      const address = this.address;
      if (address) {
        return `${address.address1} ${address.address2} ${address.city} ${address.state} ${address.postal_code}, ${address.country}`;
      } else {
        return '';
      }
    }
  },

  components: { VueGoogleAutocomplete },
  watch: { 
      fullname: function(newVal, oldVal) { // watch it
        if ('' === this.addressData.name) {
          this.addressData.name = newVal;
        }
      }
    }
};
</script>