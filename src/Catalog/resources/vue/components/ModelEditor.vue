<template>
  <div>
    <v-expansion-panels accordion multiple focusable>
      <v-expansion-panel v-for="(item, name) in groupData" :key="name">
        <v-expansion-panel-header text-left>{{ item.title }}</v-expansion-panel-header>
        <v-expansion-panel-content>
          <v-list-item v-for="(subItem, subName) in item.items" :key="subName">
            <v-layout class="bottom-line">
              <v-flex md3 class="v-middle">
                <span>{{ subItem.title }}</span>
              </v-flex>
              <v-flex md6>
                <div class="component-container">
                  <component :is="subItem.ui" v-bind="subItem" @valueChanged="configValueChanged"></component>
                </div>
              </v-flex>
              <v-flex md3>{{ subItem.description }}</v-flex>
            </v-layout>
          </v-list-item>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
  </div>
</template>

<script>
export default {
  props: {
    model: String
  },
  data() {
    return {
      //   baseRoute: "/admin/store-configurations",
      groupData: {}
    };
  },
  created() {
    //   this.calcMenus();
    //   if (this.menus === undefined) {
    //     this.fetchMenus();
    //   }
    //   this.handleRoute();
    this.fetchGroupDetails("catalog/category");
  },
  methods: {
    fetchGroupDetails() {
      this.$store.dispatch("showSpinner", "Loading details");
      axios
        .get(`/api/v1/admin/configs/groups/catalog/${this.model}`)
        .then(response => {
          this.$store.dispatch("hideSpinner");
          if (response.data && response.data.success) {
            this.groupData = response.data.data;
          }
        });
    }
  }
  //   watch: {
  //     $route() {
  //       this.handleRoute();
  //     }
  //   }
};
</script>
