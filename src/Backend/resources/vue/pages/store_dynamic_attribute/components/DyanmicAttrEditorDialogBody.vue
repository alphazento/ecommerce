<template>
  <v-card>
    <v-card-title class="headline">
      <span v-if="item.id > 0">Edit Attribute for {{itemCopy.parent_table}}</span>
      <span v-else>New Attribute for {{itemCopy.parent_table}}</span>
    </v-card-title>

    <v-card-text>
      <v-form>
        <v-layout v-for="(comp, i) of components" :key="i">
          <v-flex md3>
            <p class="subtitle-1">{{ comp.title }}:</p>
          </v-flex>
          <v-flex md9>
            <component :is="comp.ui" v-bind="comp" @valueChanged="configValueChanged"></component>
          </v-flex>
        </v-layout>
      </v-form>
    </v-card-text>

    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="green darken-1" text @click="discard">Disard</v-btn>
      <v-btn color="green darken-1" text @click="saveData">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
const CONFIG_ITEM = {
  editable: Boolean,
  options: Array,
  text: String,
  ui: String,
  value: String
};
export default {
  props: {
    editFor: String,
    mode: String,
    defines: Array[CONFIG_ITEM],
    item: Object
  },
  data() {
    return {
      configs: {},
      components: [],
      dataChanged: false,
      itemCopy: {}
    };
  },
  methods: {
    discard() {
      this.$emit("close", { success: false });
    },
    closeDialog(success, data) {
      this.$emit("close", {
        success: success,
        data: data
      });
    },
    prepareData() {
      let isNew = !this.item.id;
      let components = [];
      for (const [key, value] of Object.entries(this.item)) {
        let config = this.configs[key];
        if (config !== undefined) {
          components.push({
            idx: components.length,
            ui: isNew || config["editable"] ? config["edit_ui"] : config["ui"],
            accessor: config["value"],
            options: config["options"],
            title: config["text"],
            value: value
          });
        }
      }
      this.components = components;
      this.dataChanged = false;
      this.itemCopy = Object.assign({}, this.item);
    },
    configValueChanged(item) {
      this.dataChanged = true;
      this.components[item.idx].value = item.value;
      this.components = JSON.parse(JSON.stringify(this.components));
      this.itemCopy[item.accessor] = item.value;
    },
    saveData() {
      let id = this.itemCopy.id;
      this.$store.dispatch("showSpinner", "Saving data...");
      let service =
        this.editFor === "set" ? "dynamicattribute-set" : "dynamicattributes";
      if (id > 0) {
        axios
          .patch(`/api/v1/admin/${service}/${id}`, {
            attributes: this.itemCopy
          })
          .then(response => {
            this.$store.dispatch("hideSpinner");
            if (response.data.success) {
              this.$store.dispatch("snackMessage", "Dynamic Attribute Saved.");
              this.closeDialog(true, response.data.data);
            } else {
              this.$store.dispatch("snackMessage", response.data.message);
            }
          });
      } else {
        axios
          .post(`/api/v1/admin/${service}`, {
            attributes: this.itemCopy
          })
          .then(response => {
            if (response.data.success) {
              this.$store.dispatch("snackMessage", "Dynamic Attribute Saved.");
              this.closeDialog(true, response.data.data);
            } else {
              this.$store.dispatch("snackMessage", response.data.message);
            }
          });
      }
    }
  },
  mounted() {
    this.defines.forEach(element => {
      this.configs[element.value] = element;
    });
    this.prepareData();
  },
  watch: {
    item(nV, oV) {
      this.prepareData();
    }
  }
};
</script>
