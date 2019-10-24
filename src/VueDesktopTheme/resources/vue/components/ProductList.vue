<template>
  <div style="display:grid;">
    <div class="pp_wrap_c ">
        <div class="pp_list" v-for="(item , index) in pagiData.data" :key="index">
            <div>
                <a :href="getProductUrl(item)">
                    <span><img :src="getProductImageUrl(item)"></span>
                </a>
            </div>
            <p>
                <a :href="getProductUrl(item)">{{item.name}}</a>
            </p>
        </div>
    </div>

    <div v-if="pageable" class="page_num">
        <a v-for="i in (1, pagiData.last_page)" @click="navPage(i)" :key="i" :class="pagiData.current_page === i ? 'page_num_on' : '' ">{{i}}</a>
    </div>
  </div>
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