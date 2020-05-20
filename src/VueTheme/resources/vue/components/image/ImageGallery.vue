<template>
  <v-container fluid>
    <v-layout row>
      <v-flex v-for="(card, idx) in cards" :key="idx" :class="card.flex">
        <v-hover v-slot:default="{ hover }">
          <v-card :class="{ 'on-hover': hover }">
            <v-img
              :src="card.img"
              class="white--text align-end image-gallery-item"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="500px"
            >
              <v-card-title class="justify-center">
                <a
                  :href="card.url"
                  :class="{ 'v-btn':true, 'white--text': true, 'hilight-title': hover }"
                >{{card.title}}</a>
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
    cards: {
      type: Array
      // {
      //       title: "Pre-fab homes",
      //       img: "https://magento.r.worldssl.net/media/wysiwyg/home/home-pants.jpg",
      //       flex: "md6 xs6",
      //       url: ""
      //     },
    }
  }
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