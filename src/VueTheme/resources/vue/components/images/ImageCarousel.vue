<template>
  <v-carousel :show-arrows="true" cycle :height="'350px'">
    <v-carousel-item
      v-for="(item, index) in img_data"
      :key="index"
      reverse-transition="fade-transition"
      transition="fade-transition"
    >
      <v-sheet height="100%" tile>
        <v-row class="fill-height" align="center" justify="center">
          <image-card :item="item"></image-card>
        </v-row>
      </v-sheet>
    </v-carousel-item>
  </v-carousel>
</template>

<script>
import Slick from "vue-slick";
// import ImageSection from './ImageSection';
import ImageCard from "./ImageCard";

export default {
  props: {
    imgData: {
      type: Array
    }
  },
  data() {
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
    };
  },
  created() {
    let arr = [];
    if (this.imgData) {
      this.imgData.forEach(item => {
        arr.push(item);
      });
    }
    this.img_data = arr;
  },
  methods: {
    imageUrl(img) {
      return `background-image: url(${img})`;
    }
  },
  components: {
    Slick,
    // ImageSection
    ImageCard
  }
};
</script>