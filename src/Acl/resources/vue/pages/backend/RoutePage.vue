<template>
  <v-layout>
    <v-flex md2>
      <z-simple-model-navigator
        title="Backend ACL Management"
        :models="['Role', 'User']"
        :model="modelType"
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
                New {{modelType}}
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-tab>
          <v-icon left>mdi-lock</v-icon>
          <span>{{modelType}} Admin</span>
        </v-tab>
        <v-tab v-if="editTab">
          <v-icon left>mdi-lock</v-icon>
          <span class="error" v-if="editItem.isNew">New {{modelType}}</span>
          <span v-else>{{editItem.model.name}}</span>
          <v-btn icon color="error" @click="closeEditTab">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-tab>

        <v-tab-item>
          <!-- <z-acl-role-list scope="administrator">
            :headers="headers"
          </z-acl-role-list>-->
          <!-- filter-connect-route -->

          <config-data-table
            :schema-key="schemaKey"
            :data-api-url="uri"
            use-filter
            server-side-pagination
            @proxyAction="proxyAction"
          ></config-data-table>
        </v-tab-item>
        <v-tab-item>
          <z-dyna-attr-model-editor
            :title="modelType"
            :model-name="modelType"
            :edit-with="editItem"
            @propertyChange="propertyChange"
            @saveModel="saveModel"
          ></z-dyna-attr-model-editor>
          <z-role-relationship-management
            v-if="!editItem.isNew && modelType === 'Role'"
            :scope="scope"
            :model-id="editItem.model.id"
            :model-name="editItem.model.name"
          ></z-role-relationship-management>
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
      modelType: "Role",
      schemaKey: "",
      tab: "",
      editTab: false,
      editItem: null,
      uri: ""
    };
  },
  created() {
    this.initData(false);
  },
  methods: {
    initData(newModel) {
      const modelType = this.modelType.toLowerCase();
      this.schemaKey = `${this.scope}_${modelType}`;
      this.uri = `acl/${this.scope}/${modelType}s`;
      this.editItem = {
        isNew: newModel,
        model: {}
      };
      this.editTab = newModel;
    },
    navToModel(modelType) {
      if (this.modelType != modelType) {
        this.modelType = modelType;
        this.initData(false);
      }
    },

    newModel() {
      this.initData(true);
      this.tab = 1;
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
      const modelType = this.modelType.toLowerCase();
      axios
        .patch(
          `/api/v1/admin/acl/${this.scope}/${modelType}s/${event.model.id}`,
          {
            [event.preoperty]: event.value
          }
        )
        .then(response => {
          if (response.success) {
            Object.assign(this.editItem.model, response.data);
            this.$store.dispatch("SNACK_MESSAGE", "Updated.");
          } else {
            this.$store.dispatch("SNACK_MESSAGE", "Failed to update.");
          }
        });
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
      const modelType = this.modelType.toLowerCase();
      axios
        .post(`/api/v1/admin/acl/${this.scope}/${modelType}s`, model)
        .then(response => {
          this.$store.dispatch("HIDE_SPINNER");
        });
    },
    closeEditTab() {
      this.editTab = false;
    }
  }
};
</script>
