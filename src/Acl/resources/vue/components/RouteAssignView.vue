<template>
  <v-card class="mx-auto">
    <v-sheet class="pa-4 primary lighten-2">
      <v-text-field
        v-model="search"
        label="Search Routes"
        dark
        flat
        solo-inverted
        hide-details
        clearable
        clear-icon="mdi-close-circle-outline"
      ></v-text-field>
    </v-sheet>
    <v-card-text>
      <v-treeview
        v-model="selection"
        :items="routes"
        :search="search"
        item-key="id"
        selectable
        rounded
        hoverable
        open-on-click
      >
        <template v-slot:prepend="{ item, open }">
          <v-icon>{{ open ? 'mdi-folder-open' : 'mdi-folder' }}</v-icon>
        </template>
        <template v-slot:label="{ item }">
          <span>{{item.method}}:{{item.name}}</span>
        </template>
      </v-treeview>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: {
    scope: String,
    modelType: String,
    routeType: {
      type: String,
      default: "routes"
    },
    modelId: String | Number
  },
  data() {
    return {
      search: "",
      selection: [],
      all_routes_uri: "",
      current_model_routes_uri: "",
      routes: [],
      fetching_current_routes: false
    };
  },
  created() {
    this.initData();
    this.fetchAllRoutes();
  },
  methods: {
    initData() {
      var modelType = this.modelType.toLowerCase();
      this.all_routes_uri = `/api/v1/admin/acl/${this.scope}/routes?from=${modelType}`;
      this.current_model_routes_uri = `/api/v1/admin/acl/${this.scope}/${modelType}s/${this.modelId}/${this.routeType}`;
    },
    fetchAllRoutes() {
      this.$store.dispatch("SHOW_SPINNER", "Loading routes...");
      axios.get(this.all_routes_uri).then(response => {
        this.$store.dispatch("HIDE_SPINNER");
        if (response.success) {
          this.routes = this.convertTreeviewDataset(response.data);
          this.fetchModelsRoutes();
        } else {
          this.routes = [];
        }
      });
    },
    fetchModelsRoutes() {
      this.fetching_current_routes = true;
      this.$store.dispatch("SHOW_SPINNER", "Loading routes...");
      axios.get(this.current_model_routes_uri).then(response => {
        if (response.success) {
          const current_sets = response.data;
          this.selection = current_sets.map(item => item.id);
        }
        this.$store.dispatch("HIDE_SPINNER");
      });
    },

    convertTreeviewDataset(routes) {
      //convert routes data to Dataset which treeview can use it.
      const dataset = {};
      var index = 0;
      routes.forEach(item => {
        if (dataset[item.catalog] === undefined) {
          dataset[item.catalog] = {
            id: `c${index}`,
            name: item.catalog,
            children: []
          };
        }
        dataset[item.catalog].children.push(item);
        index++;
      });
      return Object.values(dataset);
    },

    storeRoutes() {
      axios
        .post(this.current_model_routes_uri, { ids: this.selection })
        .then(response => {
          console.log(response);
        });
    }
  },
  computed: {
    filter() {
      return (item, search, textKey) =>
        item[textKey].toLowerCase().indexOf(search.toLowerCase()) > -1;
    }
  },
  watch: {
    selection(nV, oV) {
      if (!this.fetching_current_routes) {
        if (nV.length != oV.length) {
          this.storeRoutes();
        }
      }
      this.fetching_current_routes = false;
    },
    modelType(nV, oV) {
      this.initData();
      this.fetchAllRoutes();
    },
    modelId(nV, oV) {
      this.initData();
      this.fetchModelsRoutes();
    },
    scope(nV, oV) {
      this.initData();
      this.fetchAllRoutes();
    }
  }
};
</script>
