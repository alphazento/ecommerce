<template>
  <v-card class="mx-auto">
    <v-sheet class="pa-4 primary lighten-2">
      <v-text-field
        v-model="search"
        label="Search Category Directory"
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
        :items="items"
        :search="search"
        :filter="filter"
        :open.sync="open"
        activatable
        rounded
        hoverable
        color="warning"
      >
        <template v-slot:prepend="{ item, open }">
          <v-icon>{{ open ? 'mdi-folder-open' : 'mdi-folder' }}</v-icon>
        </template>
        <template v-slot:append="{ item }">
          <v-btn icon v-if="item.level < tree_conf.level_to" @click="addCategory(item)">
            <v-icon>mdi-plus-circle</v-icon>
          </v-btn>
          <v-btn icon v-if="item.level >= tree_conf.level_from" @click="editCategory(item)">
            <v-icon>mdi-settings</v-icon>
          </v-btn>
        </template>
      </v-treeview>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: {
    value: {
      name: String,
      email: String
    },
    extraData: {
      remote_ip: String
    }
  },
  data() {
    return {
      items: [
        {
          id: 0,
          name: "Root Category",
          level: 0,
          children: []
        }
      ],
      tree_conf: {
        level_from: 0,
        level_to: 3
      },
      open: [1],
      search: null
    };
  },
  computed: {
    filter() {
      return (item, search, textKey) => item[textKey].indexOf(search) > -1;
    }
  },
  methods: {
    fetchCategories() {
      axios.get("/api/v1/admin/categories/tree").then(response => {
        if (response.data.success) {
          this.tree_conf = response.data.tree_conf;
          this.items[0].level =
            this.tree_conf.level_from > 1 ? this.tree_conf.level_from - 1 : 0;
          this.items[0].children = response.data.data;
        }
      });
    },
    addCategory(item) {
      console.log("addCategory clicked.", item);
    },
    editCategory(item) {
      console.log("editCategory clicked.", item);
    }

    // axios
    //             .get(`/api/v1/admin/configs/groups/${groupName}`)
    //             .then(response => {
    //                 this.$store.dispatch("hideSpinner");
    //                 if (response.data && response.data.success) {
    //                     this.groupData = response.data.data;
    //                 }
    //             });
  },
  mounted() {
    this.fetchCategories();
  }
};
</script>
