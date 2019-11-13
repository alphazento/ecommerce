<template>
  <v-form ref="checkout_address_form" v-model="valid" lazy-validation>
    <v-card color="lighten-1" class="mb-12" flat>
      <v-text-field
        v-model="businessname"
        :counter="60"
        :rules="nameRules"
        label="Business Name(Optional)"
      ></v-text-field>
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
    address: {
      type: Object
    }
  },
  data() {
    return {
      addressData: this.address,
      dataChanged: false,
      valid: false,
      addressRules: [
        v => !!v || "Address is required"
      ],
      businessname: this.address ? this.address.businessname : '',
      nameRules: [
        v =>
          !v || (v && v.length <= 60) ||
          "Business Name must be less than 120 characters"
      ]
    };
  },
  methods: {
    childMessage() {
      if (this.$refs.checkout_address_form.validate()) {
        if (this.dataChanged) {
          this.$store.dispatch('setShippingAddress',  this.addressData )
        }
        this.$emit("childMessage", this.step);
      }
    },
    getAddressData(addressData, placeResultData, id) {
      this.addressData = this.convertGoogleAddressToAddress(addressData);
      this.addressChanged = true;
      this.$store.dispatch('setShippingAddress', this.addressData);
    },
    convertGoogleAddressToAddress(googleAddress) {
      var address = {};
      address.city = googleAddress.locality;
      address.state = googleAddress.administrative_area_level_1;
      // address.statel2 = googleAddress.administrative_area_level_2;
      address.country = googleAddress.country;
      address.latitude = googleAddress.latitude;
      address.longitude = googleAddress.longitude;
      address.postal_code = googleAddress.postal_code;
      address.street_address1 = googleAddress.street_number;
      address.street_address2 = googleAddress.route;
      return address;
    }
  },
  computed: {
    addressText() {
      const address = this.address;
      if (address) {
        return `${address.street_address1} ${address.street_address2} ${address.city} ${address.state} ${address.postal_code}, ${address.country}`;
      } else {
        return '';
      }
    }
  },
  components: { VueGoogleAutocomplete }
};
</script>