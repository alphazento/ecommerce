<template>
  <v-list>
    <v-list-item v-for="(item, i) in switchItems" :key="i">
      <v-list-item-action>
        <v-switch v-model="item.switch" color="purple" v-on:change="changeFilter(item)"></v-switch>
      </v-list-item-action>
      <v-list-item-title>
        <span v-html="item.value"></span>({{item.amount}})
      </v-list-item-title>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  props: {
    items: {
      type: Array
    },
    filter: {
      type: String
    },
    applied: {
      type: Array
    }
  },
  data() {
    return {
      applied_ids: [],
      searchKey: '',
      switchItems: []
    };
  },

  created() {
      this.applied_ids = this.mapAppliedIds();
      this.convertSwitchItems();
      this.searchKey = `${this.filter}[]`;
  },

  methods: {
    changeFilter(item) {
      if (item.switch) {
        this.applied_ids.push(Number(item.id));
      } else {
        var index = this.applied_ids.indexOf(Number(item.id));
        if (index > -1) {
          this.applied_ids.splice(index, 1);
        }
      }
      this.$emit('filterChange', { filter: this.searchKey, data: this.applied_ids });
    },
   
    mapAppliedIds() {
      return this.applied.map(id => {
          return Number(id);
      });
    },

    convertSwitchItems() {
      this.items.forEach(item => {
        let id = Number(item.id);
        item['switch'] = this.applied_ids.includes(id);
        this.switchItems.push(item);
      })
    }
  }
};
</script>