<template>
  <v-layout>
    <v-flex md2>
      <z-simple-model-navigator
        title="Backend ACL Management"
        :models="['Role', 'User', 'Route']"
        :model="model"
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
              <v-btn color="error" @click="newModel" v-if="!editorTab">
                <v-icon>mdi-plus-circle</v-icon>
                New {{model}}
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-tab>
          <v-icon left>mdi-lock</v-icon>
          <span>Role Admin</span>
        </v-tab>
        <v-tab-item>
          <z-acl-role-list scope="administrator"></z-acl-role-list>
        </v-tab-item>
        <v-tab-item>
          <z-dyna-attr-model-editor
            :title="model"
            :model-name="'acl/role'"
            :edit-with="editItem"
            @propertyChange="propertyChange"
            @defaultAttributeSet="setDefaultAttributeSet"
            @saveModel="saveModel"
          ></z-dyna-attr-model-editor>
        </v-tab-item>
      </v-tabs>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      tab: "",
      model: "Role",
      editorTab: false
    };
  },
  methods: {
    navToModel(model) {},
    newModel() {}
  }
};
</script>
