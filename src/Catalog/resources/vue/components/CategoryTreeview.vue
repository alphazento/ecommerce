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
        :active="active"
        item-key="id"
        rounded
        hoverable
        open-on-click
      >
        <template v-slot:prepend="{ item, open }">
          <v-icon>{{ open ? 'mdi-folder-open' : 'mdi-folder' }}</v-icon>
        </template>
        <template v-slot:label="{ item }">
          <span>{{item.name}}(id:{{item.id}})</span>
        </template>
        <template v-slot:append="{ item }">
          <v-btn
            color="error"
            icon
            v-if="item.level < tree_conf.level_to && (selected_item.id !== item.id || selected_item.mode !== 'new')"
            @click="addCategory(item)"
          >
            <v-icon>mdi-plus-circle</v-icon>
          </v-btn>
          <v-btn
            color="primary"
            icon
            v-if="item.level >= tree_conf.level_from && (selected_item.id !== item.id || selected_item.mode !== 'edit')"
            @click="editCategory(item)"
          >
            <v-icon>mdi-pencil-box-multiple-outline</v-icon>
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
    },
    selectedItem: {
      mode: String,
      id: Number
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
        level_from: 3,
        level_to: 3
      },
      open: [1],
      search: null,
      selected_item: this.selectedItem
        ? this.selectedItem
        : { mode: "", id: -1 }
    };
  },
  computed: {
    filter() {
      return (item, search, textKey) =>
        item[textKey].toLowerCase().indexOf(search.toLowerCase()) > -1;
    },
    active() {
      return [this.selected_item.id];
    }
  },
  methods: {
    fetchCategories() {
      this.$store.dispatch("showSpinner", "Loading categories data");
      axios.get("/api/v1/admin/catalog/categories/tree").then(response => {
        this.$store.dispatch("hideSpinner");
        if (response.data.success) {
          this.tree_conf = response.data.tree_conf;
          this.items[0].level =
            this.tree_conf.level_from > 1 ? this.tree_conf.level_from - 1 : 0;
          this.items[0].children = response.data.data;
        }
      });
    },
    addCategory(item) {
      this.emitCategoryChange(item, "new");
    },
    editCategory(item) {
      this.emitCategoryChange(item, "edit");
    },

    emitCategoryChange(item, mode) {
      let data = {
        mode: mode,
        item: item
      };
      this.$emit("categoryChange", data);
    }
  },
  mounted() {
    this.fetchCategories();
  },
  watch: {
    selectedItem(nV) {
      this.selected_item = nV;
    }
  }
};
</script>
