<template>
  <v-expansion-panels accordion multiple focusable>
    <v-expansion-panel>
      <v-expansion-panel-header text-left>Roles</v-expansion-panel-header>
      <v-expansion-panel-content></v-expansion-panel-content>
    </v-expansion-panel>

    <v-expansion-panel>
      <v-expansion-panel-header text-left>White List Routes</v-expansion-panel-header>
      <v-expansion-panel-content>
        <z-route-assign-management
          :scope="scope"
          model-type="User"
          :model-id="modelId"
          route-type="whiteroutes"
        ></z-route-assign-management>
      </v-expansion-panel-content>
    </v-expansion-panel>

    <v-expansion-panel>
      <v-expansion-panel-header text-left>Black List Routes</v-expansion-panel-header>
      <v-expansion-panel-content>
        <z-route-assign-management
          :scope="scope"
          model-type="User"
          :model-id="modelId"
          route-type="blackroutes"
        ></z-route-assign-management>
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
