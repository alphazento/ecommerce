<template>
    <v-card v-if="editWith">
      <v-card-title :class="dirty ? 'error white--text' : 'deep-purple accent-4 white--text'">
        <span v-if="isNew">{{ title }}</span>
        <span v-else>{{model.name}}</span>
        <v-spacer></v-spacer>
        <v-btn color="primary" fab dark large v-if="dirty" @click="saveModel">
          <v-icon dark>mdi-content-save</v-icon>
        </v-btn>
      </v-card-title>
      <config-model-editor
        :model="modelName"
        :model-data="modelData"
        :with-value="false"
        @fetchSchema="fetchSchema"
        @configValueChanged="itemValueChanged"
      ></config-model-editor>
    </v-card>
</template>

<script>
import { type } from 'os';
export default {
  props: {
      title: String,
      modelName: String,
      editWith: {
        isNew: Boolean,
        model: Object
      }
  },
  data() {
    let _editWith = this.editWith ? this.editWith : { isNew: false, model: {} };
    return {
      dirty: false,
      isNew: _editWith.isNew ? _editWith.isNew : '',
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
      this.calcAvailableAttrsGroups();
      this.schemaHasFetched = true;
      if (this.modelHasFetched) {
        this.combineModel();
      }
    },
    
    bindValues(o, from) {
      for (const [key, item] of Object.entries(o)) {
        if (item && (typeof item === "object")) {
          if (item["accessor"] !== undefined) {
            item["value"] = this.accessObjectByString(
              from,
              item["accessor"]
            );
          } else {
            this.bindValues(item, from);
          }
        }
      }
    },

    modelChange(event, needConfirm) {
      if (needConfirm && this.dirty) {
        eventBus.$emit("openDialog", {
          component: "z-dialog-confirm-body",
          bind: {
            title:
              "<p>Unsaved Changes</p>If you proceed to edit new model, any changes you have made will be lost. Are you sure you want to edit new model?",
            passData: event
          },
          closeNotify: this.handleConfirm
        });
      } else {
        this.modelHasFetched = true;
        this.mergeModelData(event);
      }
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
        this.model = {
          parent_id: data.model.id,
          level: data.model.level + 1,
        };
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
        return item.name.toLowerCase() === 'default';
      });

      let defaultAttrIds = [];
      defaultGroup.forEach(group => {
        let ids = group.attributes.map(item => item.id);
        this.availableAttrsGroups[group.id] = ids;
        defaultAttrIds = defaultAttrIds.concat(ids);
      });

      this.availableAttrsGroups['default'] = defaultAttrIds;

      this.modelSchema._extra_.forEach(group => {
        if (group.name.toLowerCase() !== 'default') {
          let ids = group.attributes.map(item => item.id);
          ids = ids.concat(this.defaultAttrIds);
          this.availableAttrsGroups[group.id] = ids;
        }
      });
    },

    combineModel() {
      let groupKey = this.model.attribute_set_id ? this.model.attribute_set_id : 'default';
      let availableAttrIds = this.availableAttrsGroups[groupKey];
      let modelData = JSON.parse(JSON.stringify(this.modelSchema));

      delete modelData['_extra_'];
      for (const [key, group] of Object.entries(modelData)) {
        for(var i = group.items.length -1; i >=0; i--) {
          let item = group.items[i];
          //if is dynamic attribute, will have da_id
          if (item['da_id'] !== undefined && !availableAttrIds.includes(item['da_id'])) { 
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
        this.$emit('propertyChange', {model: this.model, preoperty: item.accessor, value: item.value});
        // this.$store.dispatch("showSpinner", "Saving Changes...");
        // axios
        //   .patch(
        //     `/api/v1/admin/catalog/categories/${this.model.id}/${item.accessor}`,
        //     {
        //       value: item.value
        //     }
        //   )
        //   .then(response => {
        //     if (response.data.success) {
        //       this.$store.dispatch("snackMessage", "Updated.");
        //     } else {
        //       this.$store.dispatch("snackMessage", "Failed to update.");
        //     }
        //   });
        // this.$emit();
      }
    },

    saveModel() {
      this.$emit('saveModel', this.model);
      // this.$store.dispatch("showSpinner", "Saving Changes...");
      // axios
      //   .post("/api/v1/admin/catalog/categories", this.model)
      //   .then(response => {
      //     this.$store.dispatch("hideSpinner");
      //     console.log(response);
      //   });
    }
  },
  watch: {
    editWith(nV, oV) {
      this.modelChange(nV, nV.isNew || nV.id !== oV.id);
    }
  }
};
</script>