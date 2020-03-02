<template>
  <v-card v-if="id>0">
    <v-card-title class="headline primary white--text">
      Available Values 
    </v-card-title>
    <v-card-subtitle class="error  white--text" v-if="error">
      {{message}}
    </v-card-subtitle>

    <v-card-text>
       <v-data-table :headers="headers" :items="attribute.options">
          <template v-slot:body="{ headers, items }">
            <tbody>
              <tr class="text-start" v-for="(row, i) of items" :key="i">
                <td v-for="(col, ci) of headers" :key="ci">
                  <v-btn v-if="ci == 0" icon @click="deleteValue(row)" color="error">
                    <v-icon>mdi-minus-circle</v-icon>
                  </v-btn>
                  <component :is="col.ui" v-bind="buildDynCompProps(col, row)"
                    v-on:valueChanged="valueChanged"
                  ></component>
                </td>
              </tr>
            </tbody>
          </template>
        </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>

export default {
  props: {
   id: Number,
   isSwatch: Boolean | Number
  },
  data() {
    return {
      attribute: {options: []},
      defines: [
         {text: "ID", ui: "z-label", accessor: "id"},
         {text: "Value", ui: "config-text-item", accessor: "value"}
      ],
      error: false,
      message: ""
    };
  },
  computed: {
    headers() {
     let defines = [this.defines[0], this.defines[1]];
     if (this.attribute.swatch) {
       defines.push(
         {text: "Swatch Value", ui: "config-text-item", accessor: "swatch_value"}
       );
     }
     return defines;
    }
  },
  methods: {
    fetchAttributeWithOptions() {
      this.$store.dispatch('showSpinner', 'Fetching mapping values...');
      return axios
          .get(`/api/v1/admin/dynamic-attributes/${this.id}/values`)
          .then(response => {
            this.$store.dispatch("hideSpinner");
            if (response.data && response.data.success) {
              this.attribute = response.data.data;
            }
            this.$store.dispatch('hideSpinner');
          });
    },
    buildDynCompProps(define, rowItem) {
      var data = Object.assign({}, define);
      data.idx = rowItem.id;
      data.value = rowItem[define.accessor];
      return data;
    },
    deleteValue(row) {

    },
    checkValueDuplicate(data) {
      var value = data[data.accessor];
      var foundItems = this.attribute.options.filter(item => {
        return item[data.accessor].toLowerCase() === value.toLowerCase();
      });
      var message = `Attribute[id=${data.idx}]'s ${data.accessor}="${value}" is duplicated. Change has been rollbacked.`;
      if (foundItems !== undefined) {
        if (foundItems.length > 1) {
          this.message = message;
          return false;
        }
        if (foundItems[0].id != data.idx) {
          this.message = message;
          return false;
        }
      }
      return true;
    },
    valueChanged(data) {
      this.error = !this.checkValueDuplicate(data);
      if (this.error) {
        data.rollback = true;
      } else {

      }
    }
  },
  mounted() {
    if (this.id) {
      this.fetchAttributeWithOptions();
    }
  },
  watch: {
    id(nV, oV) {
      this.fetchAttributeWithOptions();
    },
    isSwatch(nV, oV) {
      this.attribute.swatch = nV;
    }
  }
};
</script>
