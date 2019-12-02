<template>
    <v-layout row style="min-height:200px;">
      <v-flex :class="flex">
        <v-list two-line>
          <v-list-item v-for="(desc, title) in items" :key="title" class="listitem">
            <v-list-item-content class="listitem-title">
              <v-list-item-title v-text="title"></v-list-item-title>
            </v-list-item-content>
            <v-list-item-content class="listitem-desc">
              <v-list-item-title v-text="desc"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-flex>
    </v-layout>
</template>

<script>
  export default {
    props: {
      description: {
        type: String
      },
      flex: {
        type: String
      }
    },
    data() {
      return {
        items: {}
      }
    },
    created() {
      // this.items = JSON.parse(this.description);
    }
  }
</script>

<style lang="scss" scoped>
  .listitem {
    margin: 5px;
    border-radius: 4px;
    min-height: 30px !important;

    .listitem-title {
      margin: 5px;
      padding:0;
      color:green;
    }
    
    .listitem-desc {
      margin: 5px;
      padding:0;
      color: red;
    }
  }
</style>