<template>
  <v-card>
    <v-card-title :class="dirty ? 'error white--text' : 'deep-purple accent-4 white--text'">
      <span
        v-if="item.id > 0"
      >Attribute {{editFor}} [{{itemCopy.name}}] of {{itemCopy.parent_table}}</span>
      <span v-else>New Attribute {{editFor}}</span>
      <v-spacer></v-spacer>
      <v-btn color="primary" fab dark large v-if="dirty" @click="saveAttribute">
        <v-icon dark>mdi-content-save</v-icon>
      </v-btn>
    </v-card-title>

    <config-model-editor :model-data="modelData" @configValueChanged="itemValueChanged"></config-model-editor>
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
          title: "Details",
          items: []
        }
      },
      dirty: false
    };
  },
  methods: {
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
            text: config["text"],
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
      let id = this.itemCopy.id;
      if (id > 0) {
        this.$store.dispatch("SHOW_SPINNER", "Saving data...");
        let service =
          this.editFor === "Set"
            ? "dynamic-attribute-sets"
            : "dynamic-attributes";
        axios
          .patch(`/api/v1/admin/${service}/${id}`, {
            attributes: this.itemCopy
          })
          .then(response => {
            this.$store.dispatch("HIDE_SPINNER");
            if (response.success) {
              this.dirty = false;
              this.$store.dispatch("snackMessage", "Dynamic Attribute Saved.");
              this.$emit("itemUpdated", response.data);
            } else {
              this.$store.dispatch("snackMessage", response.message);
            }
          });
      }
    },
    saveAttribute() {
      this.$store.dispatch("SHOW_SPINNER", "Saving data...");
      let service =
        this.editFor === "Set"
          ? "dynamic-attribute-sets"
          : "dynamic-attributes";
      axios
        .post(`/api/v1/admin/${service}`, {
          attributes: this.itemCopy
        })
        .then(response => {
          this.$store.dispatch("HIDE_SPINNER");
          if (response.success) {
            this.dirty = false;
            this.$store.dispatch("snackMessage", "Dynamic Attribute Saved.");
            this.$emit("itemUpdated", response.data);
          } else {
            this.$store.dispatch("snackMessage", response.message);
          }
        });
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
