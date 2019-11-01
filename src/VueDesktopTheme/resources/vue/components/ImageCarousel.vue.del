<template>
  <slick  ref="slick"  :options="options"  >
    <image-card v-for="(item, index) in img_data" :key="index" :item="item">
    </image-card>
  </slick>
</template>

<script>
import Slick from 'vue-slick';
// import ImageSection from './ImageSection';
import ImageCard from './ImageCard';

export default {
    props: {
      imgData: {
        type: Array
      }
    },
    data () {
      return {
        img_data: {},
        options: {
          dots: true,
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: true,
          speed: 500,
          autoplaySpeed: 3000,
          cssEase: "linear",
          pauseOnHover: true
        }
      }
    },
    created(){
      let arr = [];
      if (this.imgData) {
        this.imgData.forEach(item => {
          arr.push(item)
        });
      }
      this.img_data = arr;
    },
    methods: {
      imageUrl(img){
        return `background-image: url(${img})`;
      }
    },
    components: {
      Slick,
      // ImageSection
      ImageCard
    }
  }
</script>

<style lang="scss">
  @import '@Zento_VueDesktopTheme/components/slick-theme.scss';
  @import 'node_modules/slick-carousel/slick/slick.scss';
</style>