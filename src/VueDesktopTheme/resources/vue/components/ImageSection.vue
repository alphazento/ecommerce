<template>
    <section class="content-section" >
      <div class="content-section-container">
        <h2 class="content-section-title">{{item.title}} <span class="jss297"></span> </h2>
        <p class="content-section-reserve"></p>
        <a class="content-section-button" tabindex="0" role="button" variant="button" href="/collections/erin-recommends.html">
          <span class="content-section-button-text">View</span>
          <span class="jss422"></span>
        </a>
        <div class="content-section-image" :style="imageUrl(item.img)"></div>
      </div>
    </section>
</template>

<script>
export default {
    name: 'imagesection',
    props: {
      item: {
        type: Object
      }
    },
    methods: {
      imageUrl(img){
        return `background-image: url(${img})`;
      }
    }
  }
</script>

<style lang="scss">
  @import '@Zento_VueDesktopTheme/components/image-section.scss';
</style>