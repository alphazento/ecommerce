<template>
 <v-footer
    class="py-4"
    dark
    height="auto"
  >
    <v-container mx-auto>
      <v-layout wrap>
        <v-flex xs9>
          <v-img src="'/baicy_desktoptheme/image/logo_w.png'"/>
        </v-flex>
      </v-layout>
    </v-container>
  </v-footer>
</template>
<script>
  export default {
    name: 'myfooter',
    props: {
      links: {
        type: Array
      },
      logo: {
        type: String
      }
    },
    methods: {
     
    }
  }
</script>