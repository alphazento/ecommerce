<template>
  <v-layout>
    <v-flex md2>
      <z-simple-model-navigator
        title="Backend ACL Management"
        :models="['Role', 'User', 'Route']"
        :model="modelName"
        @navToModel="navToModel"
      ></z-simple-model-navigator>
    </v-flex>
    <v-flex md10>
      <v-tabs v-model="tab">
        <v-menu bottom right>
          <template v-slot:activator="{ on }">
            <v-btn text class="align-self-center mr-4" v-on="on">
              more
              <v-icon right>mdi-menu-down</v-icon>
            </v-btn>
          </template>
          <v-list class="grey lighten-3">
            <v-list-item>
              <v-btn color="error" @click="newModel" v-if="!editTab">
                <v-icon>mdi-plus-circle</v-icon>
                New {{modelName}}
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-tab>
          <v-icon left>mdi-lock</v-icon>
          <span>Role Admin</span>
        </v-tab>
        <v-tab v-if="editTab">
        </v-tab>

        <v-tab-item>
          <!-- <z-acl-role-list scope="administrator">
            :headers="headers"
            </z-acl-role-list> -->
          <config-data-table
            :schema-key="schemaKey"
            :data-api-url="uri"
            filter-connect-route
            use-filter
            server-side-pagination
            @dataChanged="dataChanged"
            @proxyAction="proxyAction"
          ></config-data-table>
        </v-tab-item>
        <v-tab-item>
          <z-dyna-attr-model-editor
            :title="modelName"
            :model-name="modelName"
            :edit-with="editItem"
            @propertyChange="propertyChange"
            @saveModel="saveModel"
          ></z-dyna-attr-model-editor>
            <!-- @defaultAttributeSet="setDefaultAttributeSet" -->
        </v-tab-item>
      </v-tabs>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      scope: "administrator",
      modelName: "Role",
      schemaKey: "",
      tab: "",
      editTab: false,
      editItem: null,
      uri: '',
    };
  },
  created() {
    this.initData(false);
    console.log(this.schemaKey);
  },
  methods: {
    initData(newModel) {
        this.schemaKey = `${this.scope}_${this.modelName}`;
        this.uri = `acl/${this.scope}/` + this.modelName.toLowerCase() + 's';
        this.editItem = {
          isNew: false,
          model: {}
        };
        this.editTab = newModel;
    },
    navToModel(modelName) {
      if (this.modelName != modelName) {
        this.modelName = modelName;
        this.initData(false);
      }
    },

    newModel() {
      this.initData(true);
    },

    dataChanged(event) {
      event._raw[event.accessor] = event.value;
      axios
        .patch(`/api/v1/admin/${this.uri}/${event._raw.id}`, event._raw)
        .then(response => {
          if (response.success) {
            this.$store.dispatch("SNACK_MESSAGE", "Updated.");
          } else {
            event.rollback = true;
          }
        });
    },

    propertyChange(event) {
      this.$store.dispatch("SHOW_SPINNER", "Saving Changes...");
      // axios
      //   .patch(
      //     `/api/v1/admin/catalog/products/${event.model.id}/${event.preoperty}`,
      //     {
      //       value: event.value
      //     }
      //   )
      //   .then(response => {
      //     if (response.success) {
      //       Object.assign(this.editItem.model, response.data);
      //       this.$store.dispatch("SNACK_MESSAGE", "Updated.");
      //     } else {
      //       this.$store.dispatch("SNACK_MESSAGE", "Failed to update.");
      //     }
      //   });
          this.$store.dispatch("HIDE_SPINNER");
    },

    proxyAction(event) {
      switch (event.action) {
        case "editModel":
          this.editItem = { isNew: false, model: event.data };
          this.tab = 1;
          this.editTab = true;
          break;
        case "deleteModel":
          break;
      }
    },

    saveModel(model) {
      this.$store.dispatch("SHOW_SPINNER", "Saving Changes...");
          this.$store.dispatch("HIDE_SPINNER");
      // axios
      //   .post("/api/v1/admin/catalog/products", this.model)
      //   .then(response => {
      //     this.$store.dispatch("HIDE_SPINNER");
      //   });
    },
  },
};
</script>
