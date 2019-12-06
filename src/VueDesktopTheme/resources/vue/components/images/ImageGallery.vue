<template>
  <v-container fluid>
    <v-layout row>
      <v-flex v-for="(card, idx) in cards" :key="idx" :class="card.flex">
        <v-hover v-slot:default="{ hover }">
          <v-card :class="{ 'on-hover': hover }">
            <v-img
              :src="card.src"
              class="white--text align-end image-gallery-item"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="500px"
            >
              <v-card-title class="justify-center">
                <div :class="{ 'hilight-title': hover }">{{card.title}}</div>
              </v-card-title>
            </v-img>
          </v-card>
        </v-hover>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  props: {
    items: {
      type: Object
    }
  },
  data: () => ({
    cards: [
      {
        title: "Pre-fab homes",
        src: "https://magento.r.worldssl.net/media/wysiwyg/home/home-pants.jpg",
        flex: { md4: true, xs6: true }
      },
      {
        title: "Pre-fab homes",
        src:
          "https://magento.r.worldssl.net/media/wysiwyg/home/home-t-shirts.png",
        flex: { md8: true, xs6: true }
      },
      {
        title: "Favorite road trips",
        src: "https://magento.r.worldssl.net/media/wysiwyg/home/home-erin.jpg",
        flex: { md5: true, xs6: true }
      },
      {
        title: "Favorite road trips",
        src:
          "https://magento.r.worldssl.net/media/wysiwyg/home/home-performance.jpg",
        flex: { md4: true, xs6: true }
      },
      {
        title: "Best airlines",
        src: "https://magento.r.worldssl.net/media/wysiwyg/home/home-eco.jpg",
        flex: { md3: true, xs12: true }
      }
    ]
  })
};
</script>

<style lang="scss">
.image-gallery-item {
  .v-responsive__content {
    margin-top: auto;
    margin-bottom: auto;
  }
}
</style>

<style scoped>
.v-card {
  transition: opacity 0.2s ease-in-out;
  text-transform: uppercase;
}

.v-card:not(.on-hover) {
  opacity: 0.7;
}

.hilight-title {
  outline: solid 4px white;
  padding: 10px;
  cursor: pointer;
}
</style>