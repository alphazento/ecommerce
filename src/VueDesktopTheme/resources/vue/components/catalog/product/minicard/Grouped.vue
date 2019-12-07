<template>
  <v-hover v-slot:default="{ hover }">
    <v-card class="mx-auto">
      <a :href="getProductUrl(product)">
        <v-img :src="getProductImageUrl(product)" height="280px" contain>
          <v-container fill-height fluid>
            <v-layout fill-height>
              <v-flex xs12 align-end flexbox></v-flex>
            </v-layout>
          </v-container>
        </v-img>
      </a>
      <v-card-title>
        <div class="mx-5">
          <p class="title blue--text">{{ product.desc.name }}</p>
          <!-- <p class="ma-0 subheading body-1 font-weight-bold text-left"></p> -->
          <br />
          <v-rating readonly small dense background-color="orange" color="orange" v-model="rating"></v-rating>
          <span class="title">$</span>
          &nbsp
          <del class>$</del>
        </div>
      </v-card-title>
    </v-card>
  </v-hover>
</template>

<script>
import SimpleCard from "./Simple";
export default {
  extends: SimpleCard,
  props: {
    product: {
      type: Object
    }
  }
};
</script>

