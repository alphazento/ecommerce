<template>
  <div>
    <div class="display--flex" v-if="!manual_mode">
      <v-text-field
        ref="autocomplete"
        type="text"
        :class="classname"
        :id="id"
        :placeholder="placeholder"
        v-model="autocompleteText"
        @focus="onFocus()"
        @blur="onBlur()"
        @change="onChange"
        @keypress="onKeyPress"
        @keyup="onKeyUp"
        :rules="addressRules"
      ></v-text-field>
      <v-btn v-if="allowManualInput" icon color="purple" large @click="toggleAddressInput">
        <v-icon>mdi-arrange-bring-forward</v-icon>
        <!-- <v-icon>mdi-aspect-ratio</v-icon> -->
      </v-btn>
    </div>
    <div v-else>
      <manual-address-input>
      </manual-address-input>
      <v-layout>
        <v-btn text color="purple" large @click="toggleAddressInput">Use Google Address Input</v-btn>
      </v-layout>
    </div>
  </div>
</template>

<script>
import VueGoogleAutocomplete from "vue-google-autocomplete";
export default {
  extends: VueGoogleAutocomplete,
  props: {
    allowManualInput: Boolean,
    address: String,
    rules: Array
  },
  data() {
    var data = VueGoogleAutocomplete.data();
    data.autocompleteText = this.address;
    data.initAddress = this.address;
    data.inputChangedButNotSet = false;
    data.addressRules = this.rules ? this.rules : [];
    data.addressRules.push(
      v =>
        (v && !this.inputChangedButNotSet) ||
        "Address changed, but any validated address been seleted."
    );
    data.manualAddress = {
      address1: "",
      address2: "",
      city: "",
      state: "",
      country: "",
      postal_code: ""
    };
    data.manual_mode = false;
    return data;
  },
  methods: {
    onChange() {
      this.inputChangedButNotSet = this.initAddress !== this.autocompleteText;
      VueGoogleAutocomplete.methods.onChange.call(this);
    },
    onPlaceChanged() {
      VueGoogleAutocomplete.methods.onPlaceChanged.call(this);
      this.inputChangedButNotSet = false;
    },
    toggleAddressInput() {
      this.manual_mode = !this.manual_mode;
    }
  }
};
</script>

<style scoped>
.display--flex {
  display: flex;
}
</style>