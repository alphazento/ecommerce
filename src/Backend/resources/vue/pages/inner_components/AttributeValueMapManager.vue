<template>
  <v-card v-if="id > 0">
    <v-card-title class="headline primary white--text">
      Available Values
    </v-card-title>
    <v-card-subtitle class="error  white--text" v-if="error">
      {{ message }}
    </v-card-subtitle>

    <v-card-text>
      <v-data-table :headers="tableHeaders" :items="attribute.options">
        <template v-slot:body="{ headers, items }">
          <tbody>
            <tr class="text-start" v-for="(row, i) of items" :key="i">
              <td v-for="col of headers" :key="col.accessor">
                <v-btn
                  v-if="col.accessor == '_action_'"
                  icon
                  @click="deleteValue(row)"
                  color="error"
                >
                  <v-icon>mdi-minus-circle</v-icon>
                </v-btn>
                <component
                  v-else
                  :is="col.ui"
                  v-bind="buildDynCompProps(col, row)"
                  v-on:valueChanged="valueChanged"
                ></component>
              </td>
            </tr>
          </tbody>
        </template>
      </v-data-table>
    </v-card-text>
    <v-card-actions>
      <div v-if="addNew">
        <v-btn @click="toggleNewValue" color="warning" large>
          <v-icon>mdi-minus-circle</v-icon>Cancel
        </v-btn>
        <v-btn
          @click="saveNewValue"
          color="primary"
          large
          :disabled="!newValueDirty"
        >
          <v-icon dark>mdi-content-save</v-icon>Save
        </v-btn>
      </div>
      <v-btn v-else @click="toggleNewValue" color="primary" large>
        <v-icon>mdi-plus-circle</v-icon>Add New Value
      </v-btn>
    </v-card-actions>
    <v-container v-if="addNew">
      <v-layout row v-for="item of tableHeaders.slice(2)" :key="item.accessor">
        <v-flex md4>
          {{ item.text }}
        </v-flex>
        <v-flex md8>
          <component
            :is="item.ui"
            v-on:valueChanged="newValueChanged"
            v-bind="buildDynCompProps(item, newValue)"
          ></component>
        </v-flex>
      </v-layout>
    </v-container>
  </v-card>
</template>

<script>
export default {
  props: {
    id: Number,
    useContainer: Boolean | Number,
  },
  data() {
    return {
      attribute: { options: [] },
      headerDefine: [
        { text: "Action", ui: false, accessor: "_action_" },
        { text: "ID", ui: "z-label", accessor: "id" },
        { text: "Value", ui: "config-text-item", accessor: "value" },
      ],
      error: false,
      message: "",
      addNew: false,
      newValue: {
        value: "",
        use_container: "",
      },
      newValueDirty: false,
    };
  },
  computed: {
    tableHeaders() {
      let headerDefine = [...this.headerDefine];
      if (this.attribute.use_container) {
        headerDefine.push({
          text: "Value use in container",
          ui: "config-text-item",
          accessor: "value_in_container",
        });
      }
      return headerDefine;
    },
  },
  methods: {
    fetchAttributeWithOptions() {
      this.$store.dispatch("showSpinner", "Fetching mapping values...");
      return axios
        .get(`/api/v1/admin/dynamic-attributes/${this.id}/values`)
        .then((response) => {
          this.$store.dispatch("HIDE_SPINNER");
          if (response && response.success) {
            this.attribute = response.data;
          }
          this.$store.dispatch("hideSpinner");
        });
    },
    buildDynCompProps(define, rowItem) {
      var data = Object.assign({}, define);
      data.idx = rowItem.id;
      data.value = rowItem[define.accessor];
      return data;
    },
    checkValueDuplicate(data) {
      var value = data[data.accessor];
      var foundItems = this.attribute.options.filter((item) => {
        return item[data.accessor].toLowerCase() === value.toLowerCase();
      });
      var message = `Attribute[id=${data.idx}]'s ${data.accessor}="${value}" is duplicated. Change has been rollbacked.`;
      if (foundItems !== undefined && foundItems.length > 0) {
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
    },
    toggleNewValue() {
      this.addNew = !this.addNew;
      this.newValue.value = "";
      this.newValue.use_container = "";
      this.newValueDirty = false;
    },
    deleteValue(item) {},
    newValueChanged(data) {
      this.newValue[data.accessor] = data.value;
      this.newValueDirty = true;
      this.error = !this.checkValueDuplicate(data);
      if (this.error) {
        this.newValueDirty = false;
      }
    },
    saveNewValue() {},
  },
  mounted() {
    if (this.id) {
      this.fetchAttributeWithOptions();
    }
  },
  watch: {
    id(nV, oV) {
      this.addNew = true;
      this.toggleNewValue();
      this.fetchAttributeWithOptions();
    },
    useContainer(nV, oV) {
      this.attribute.useContainer = nV;
    },
  },
};
</script>
