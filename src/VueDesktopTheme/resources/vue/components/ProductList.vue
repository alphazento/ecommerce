<template>
    <v-container fluid >
      <v-layout row>
        <v-flex v-for="(item , index) in pagiData.data" :key="index" md4 xs6>
          <product-simple-card :product="item">
          </product-simple-card>
        </v-flex>
      </v-layout>
      <div v-if="pageable" class="page_num">
          <a v-for="i in (1, pagiData.last_page)" @click="navPage(i)" :key="i" :class="pagiData.current_page === i ? 'page_num_on' : '' ">{{i}}</a>
      </div>
  </v-container>
</template>

<script>
  var mixin = require('../mixin/catalogpollyfill')
  export default {
    name: 'imageslider',
    mixins: [mixin.default],
    props: {
      apiUrl: {
        type: String
      },
      pagination: {
        type: Object
      },
      pageable: {
        type: Boolean
      }
    },
    data () {
      return {
        pagiData: {}
      }
    },
    created(){
      this.pagiData = this.pagination;
      console.log('pagination', this.pagination);
    },
    mounted(){
    },
    methods: {
      navPage(page){
        axios
          .get(this.apiUrl + '?page=' + page)
          .then(response => {
            this.pagiData = response.data.data.products;
          })
      }
    }
  }
</script>