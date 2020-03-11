<template>
    <v-carousel cycle show-arrows light height="100%" class="product__image-carousel">
        <v-carousel-item
            v-for="image in images"
            :key="image"
            reverse-transition="fade-transition"
            transition="fade-transition"
        >
            <v-sheet height="100%" tile>
                <v-row class="fill-height" align="center" justify="center">
                    <img style="width:auto;height:100%;" :src="image" alt="">
                </v-row>
            </v-sheet>
        </v-carousel-item>
    </v-carousel>
</template>

<script>
export default {
    props: {
        images: Array
    }
};
</script>