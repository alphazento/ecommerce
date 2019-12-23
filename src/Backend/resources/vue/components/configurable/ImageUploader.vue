<template>
    <v-layout>
        <v-flex md6 v-if="!!innerValue">
            <v-img :src="innerValue"></v-img>
        </v-flex>
        <v-flex md6>
            <v-file-input
                label="Select your image file"
                filled
                show-size
                accept="image/png, image/jpeg, image/jpg, image/bmp, image/gif"
                :rules="rules"
                prepend-icon="mdi-camera"
                @change="fileChanged"
            ></v-file-input>
        </v-flex>
    </v-layout>
</template>

<script>
import BaseLabel from "./Label";
export default {
    extends: BaseLabel,
    props: {
        maxSize: {
            type: Number
        }
    },
    
    data() {
        return {
            max_size: this.maxSize === undefined ? 20 : this.maxSize,
            rules: [
                value => !value || value.size < (this.max_size * 1024*1024) || 'Avatar size should be less than '+ this.max_size +' MB!'
            ],
        }
    },
    methods: {
        fileChanged(file) {
            console.log('fileChanged', file);
        }
    }
};
</script>
