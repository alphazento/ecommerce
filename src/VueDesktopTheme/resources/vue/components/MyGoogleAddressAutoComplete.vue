<template>
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
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete'
export default {
  extends: VueGoogleAutocomplete,
  props: {
    address : {
      type: String
    },
    rules: {
      type: Array
    }
  },
  data() {
    var data = VueGoogleAutocomplete.data();
    data.autocompleteText = this.address;
    data.initAddress = this.address;
    data.inputChangedButNotSet = false;
    data.addressRules = this.rules ? this.rules : [];
    data.addressRules.push(
        v => (v && !this.inputChangedButNotSet) || "Address changed, but any validated address been seleted."
    );
    return data;
  },
  methods: {
    onChange () {
      this.inputChangedButNotSet = (this.initAddress !== this.autocompleteText);
      VueGoogleAutocomplete.methods.onChange.call(this);
    },
    onPlaceChanged() {
      VueGoogleAutocomplete.methods.onPlaceChanged.call(this);
      this.inputChangedButNotSet = false;
    }
  }
};
</script>