<template>
  <div>
    <v-expansion-panels accordion multiple focusable>
      <v-expansion-panel v-for="(item, name) in model_data" :key="name">
        <v-expansion-panel-header text-left>{{ item.text }}</v-expansion-panel-header>
        <v-expansion-panel-content>
          <template v-for="(subItem, subName) in item.items">
            <v-list-item :key="subName">
              <v-layout class="bottom-line">
                <v-flex md2 class="v-middle">
                  <span>{{ subItem.text }}</span>
                </v-flex>
                <v-flex md10>
                  <div class="component-container">
                    <span>{{ subItem.description }}</span>
                    <component :is="subItem.ui" v-bind="subItem" @valueChanged="configValueChanged"></component>
                  </div>
                </v-flex>
              </v-layout>
            </v-list-item>
            <v-divider :key="subItem.text"></v-divider>
          </template>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
  </div>
</template>

<script>
export default {
  props: {
    model: String,
    modelData: Object,
    modelDefineFrom: {
      type: String,
      default: "metadata/models"
    }
  },
  data() {
    return {
      model_data: this.modelData ? this.modelData : {}
    };
  },
  created() {
    if (this.model) {
      this.fetchModelSchema(this.model);
    }
  },
  methods: {
    fetchModelSchema(model) {
      if (model && model !== "") {
        this.$store.dispatch("SHOW_SPINNER", "Loading details");
        axios
          .get(`/api/v1/admin/${this.modelDefineFrom}/${model}`)
          .then(response => {
            this.$store.dispatch("HIDE_SPINNER");
            if (response && response.success) {
              this.model_data = response.data;
              this.$emit("fetchSchema", this.model_data);
            } else {
              this.model_data = { error: { text: response.message } };
            }
          });
      }
    },
    configValueChanged(item) {
      this.$emit("configValueChanged", item);
    }
  },
  watch: {
    model(nv, ov) {
      this.fetchModelSchema(nv);
    },
    modelData(nv, ov) {
      //normally fetch model data by this component,
      //but some use case need to modify the model_data outsiede, so it can pass it back.
      this.model_data = nv;
    }
  }
};
</script>

<style scoped>
.v-middle {
  margin-top: auto;
  margin-bottom: auto;
}

.component-container {
  padding-top: 18px;
}

.v-expansion-panel--active > .v-expansion-panel-header {
  background-color: #6aaaff;
  color: white;
}
</style>
