<template>
  <v-card>
    <v-card-title :class="dirty ? 'error white--text' : 'deep-purple accent-4 white--text'">
      <span v-if="item.id > 0">Attribute [{{itemCopy.attribute_name}}] of {{itemCopy.parent_table}}</span>
      <span v-else>New Attribute for {{itemCopy.parent_table}}</span>
      <v-spacer></v-spacer>
      <v-btn color="primary" fab dark large v-if="dirty" @click="saveAttribute">
        <v-icon dark>mdi-content-save</v-icon>
      </v-btn>
    </v-card-title>

    <config-model-editor
      :model-data="modelData"
      :with-value="false"
      @configValueChanged="itemValueChanged"
    ></config-model-editor>
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
      itemCopy: {},
      modelData: {
        default: {
          title: "Dynamic Attribute Settings",
          items: []
        }
      },
      dirty: false
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
      this.modelData.default.items = this.components;
      this.itemCopy = Object.assign({}, this.item);
    },
    itemValueChanged(item) {
      this.dirty = true;
      this.components[item.idx].value = item.value;
      this.components = JSON.parse(JSON.stringify(this.components));
      this.itemCopy[item.accessor] = item.value;
    },
    saveAttribute() {
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
