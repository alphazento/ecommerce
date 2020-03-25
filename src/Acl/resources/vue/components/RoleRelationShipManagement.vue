<template>
  <v-expansion-panels accordion multiple focusable>
    <v-expansion-panel v-if="modelName != 'root'">
      <v-expansion-panel-header text-left>APIs this role can access</v-expansion-panel-header>
      <v-expansion-panel-content>
        <z-route-assign-management :scope="scope" model-type="Role" :model-id="modelId"></z-route-assign-management>
      </v-expansion-panel-content>
    </v-expansion-panel>

    <v-expansion-panel>
      <v-expansion-panel-header text-left>Users</v-expansion-panel-header>
      <v-expansion-panel-content>
        <z-role-users-management :scope="scope" :role-id="modelId"></z-role-users-management>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>

<script>
export default {
  props: {
    scope: String,
    modelId: String | Number,
    modelName: String | Number
  }
};
</script>
