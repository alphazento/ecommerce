<template>
  <v-card v-if="editWith">
    <v-card-title :class="dirty ? 'error white--text' : 'deep-purple accent-4 white--text'">
      <span v-if="isNew" class="warning">{{ newModelTitle }}</span>
      <span v-else>{{model.name}}</span>
      <v-spacer></v-spacer>
      <v-btn color="primary" fab dark large v-if="dirty" @click="saveModel">
        <v-icon dark>mdi-content-save</v-icon>
      </v-btn>
    </v-card-title>
    <config-model-editor
      :model="modelName"
      :model-data="modelData"
      @fetchSchema="fetchSchema"
      @configValueChanged="itemValueChanged"
    ></config-model-editor>
  </v-card>
</template>

<script>
import { type } from "os";
export default {
  props: {
    newModelTitle: String,
    modelName: String,
    editWith: {
      isNew: Boolean,
      model: Object
    },
    newModel: Object
  },
  data() {
    let _editWith = this.editWith ? this.editWith : { isNew: false, model: {} };
    return {
      dirty: false,
      isNew: _editWith.isNew ? _editWith.isNew : "",
      model: _editWith.model ? _editWith.model : {},
      modelHasFetched: _editWith.model && _editWith.model.id,
      schema: {},
      schemaHasFetched: false,
      modelData: {},
      availableAttrsGroups: {}
    };
  },
  methods: {
    accessObjectByString(o, s, nV, w) {
      s = s.replace(/\[(\w+)\]/g, ".$1"); // convert indexes to properties
      s = s.replace(/^\./, ""); // strip a leading dot
      var a = s.split(".");
      var pK = "",
        pV = null; //previous key and value
      for (var i = 0, n = a.length; i < n; ++i) {
        var k = a[i];
        if (k in o) {
          pK = k;
          pV = o;
          o = o[k];
        } else {
          if (w) {
            o[k] = nV;
          }
          return;
        }
      }
      if (w) {
        pV[pK] = nV;
      }
      return o;
    },

    fetchSchema(schema) {
      this.modelSchema = schema;
      this.defaultModel = JSON;
      this.calcAvailableAttrsGroups();
      this.schemaHasFetched = true;
      if (this.modelHasFetched || this.editWith) {
        this.modelHasFetched = true;
        this.combineModel();
      }
    },

    bindValues(o, from) {
      for (const [key, item] of Object.entries(o)) {
        if (item && typeof item === "object") {
          if (item["accessor"] !== undefined) {
            item["value"] = this.accessObjectByString(from, item["accessor"]);
          } else {
            this.bindValues(item, from);
          }
        }
      }
    },

    modelChange(event, needConfirm) {
      console.log("needConfirm && this.dirty", needConfirm, this.dirty);
      if (needConfirm && this.dirty) {
        this.confirm(event);
      } else {
        this.modelHasFetched = true;
        this.mergeModelData(event);
      }
    },

    confirm(passData) {
      eventBus.$emit("openDialog", {
        component: "z-dialog-confirm-body",
        bind: {
          title:
            "<p>Unsaved Changes</p>If you proceed to edit new model, any changes you have made will be lost. Are you sure you want to edit new model?",
          passData: passData
        },
        closeNotify: this.handleConfirm
      });
    },

    handleConfirm(result) {
      if (result.success) {
        this.modelHasFetched = true;
        this.mergeModelData(result.data);
      }
    },

    mergeModelData(data) {
      this.isNew = data.isNew;
      if (this.isNew) {
        this.model = JSON.parse(JSON.stringify(this.newModel));
      } else {
        this.model = JSON.parse(JSON.stringify(data.model));
      }

      if (this.schemaHasFetched) {
        this.combineModel();
      }

      this.dirty = false;
    },

    calcAvailableAttrsGroups() {
      let defaultGroup = this.modelSchema._extra_.filter(item => {
        return item.name.toLowerCase() === "default";
      });

      let defaultAttrIds = [];
      defaultGroup.forEach(group => {
        let ids = group.attributes.map(item => item.id);
        this.availableAttrsGroups[group.id] = ids;
        defaultAttrIds = defaultAttrIds.concat(ids);
      });

      this.availableAttrsGroups["default"] = defaultAttrIds;

      this.modelSchema._extra_.forEach(group => {
        if (group.name.toLowerCase() !== "default") {
          let ids = group.attributes.map(item => item.id);
          ids = ids.concat(this.defaultAttrIds);
          this.availableAttrsGroups[group.id] = ids;
        }
      });

      this.$emit("defaultAttributeSet", defaultGroup);
    },

    combineModel() {
      let groupKey = this.model.attribute_set_id
        ? this.model.attribute_set_id
        : "default";
      let availableAttrIds = this.availableAttrsGroups[groupKey];
      let modelData = JSON.parse(JSON.stringify(this.modelSchema));

      delete modelData["_extra_"];
      for (const [key, group] of Object.entries(modelData)) {
        for (var i = group.items.length - 1; i >= 0; i--) {
          let item = group.items[i];
          //if is dynamic attribute, will have da_id
          if (
            item["da_id"] !== undefined &&
            !availableAttrIds.includes(item["da_id"])
          ) {
            group.items.splice(i, 1);
          }
        }
        if (group.items.length === 0) {
          delete modelData[key];
        }
      }

      this.bindValues(modelData, this.model);
      this.modelData = Object.assign({}, modelData);
    },

    itemValueChanged(item) {
      this.accessObjectByString(this.model, item.accessor, item.value, true);
      this.bindValues(this.modelData, this.model);
      this.modelData = Object.assign({}, this.modelData);
      if (this.isNew) {
        this.dirty = true;
      } else {
        this.$emit("propertyChange", {
          model: this.model,
          preoperty: item.accessor,
          value: item.value
        });
      }
    },

    saveModel() {
      this.$emit("saveModel", this.model);
    }
  },
  created() {
    if (this.editWith !== undefined) {
      this.modelChange(this.editWith, false);
    }
  },
  watch: {
    editWith(nV, oV) {
      this.modelChange(nV, nV.isNew || nV.model.id !== oV.model.id);
    }
  }
};
</script>