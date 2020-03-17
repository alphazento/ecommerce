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
            v-if="canShowAddBtn(item)"
            @click="addCategory(item)"
          >
            <v-icon>mdi-plus-circle</v-icon>
          </v-btn>
          <v-btn
            color="primary"
            icon
            v-if="canShowEditBtn(item)"
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
    editItem: {
      isNew: Boolean,
      model: Object
    },
    refresh: Number
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
      edit_item: this.editItem
        ? this.editItem
        : { model:{id: -1}, isNew: false }
    };
  },
  computed: {
    filter() {
      return (item, search, textKey) =>
        item[textKey].toLowerCase().indexOf(search.toLowerCase()) > -1;
    },
    active() {
      var id = this.editItem ? this.editItem.model.id : 0;
      return [id];
    }
  },
  methods: {
    fetchCategories() {
      this.$store.dispatch("showSpinner", "Loading categories data");
      axios.get("/api/v1/admin/catalog/categories/tree").then(response => {
        this.$store.dispatch("hideSpinner");
        if (response.success) {
          this.tree_conf = response.tree_conf;
          this.items[0].level =
            this.tree_conf.level_from > 1 ? this.tree_conf.level_from - 1 : 0;
          this.items[0].children = response.data;
        }
      });
    },
    addCategory(item) {
      this.emitSelectedItemChange(item, true);
    },
    editCategory(item) {
      this.emitSelectedItemChange(item, false);
    },

    emitSelectedItemChange(item, isNew) {
      let data = {
        isNew: isNew,
        model: item
      };
      this.$emit("selectedItemChange", data);
    },

    canShowAddBtn(item) {
      var level =  item.level < this.tree_conf.level_to;
      if (level && this.editItem) {
        return this.editItem.isNew || this.editItem.model.id !== item.id;
      }
      return false;
    },

    canShowEditBtn(item) {
      var level =  item.level >= this.tree_conf.level_from;
      if (level && this.editItem) {
        return !this.editItem.isNew || this.editItem.model.id !== item.id;
      }
      return false;
    }
  },
  mounted() {
    this.fetchCategories();
  },
  watch: {
    selectedItem(nV) {
      this.edit_item = nV;
    },
    refresh(nV, oV) {
      if (nV != oV) {
       this.fetchCategories();
      }
    }
  }
};
</script>
