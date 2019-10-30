<template>
  <v-card
    class="mx-auto"
  >
    <v-img
      class="white--text align-end"
      :src="item.img"
    >
      <v-card-title>
        {{item.title}}
      </v-card-title>
    </v-img>
  </v-card>
</template>

<script>
export default {
    props: {
      item: {
        type: Object
      }
    }
  }
</script>