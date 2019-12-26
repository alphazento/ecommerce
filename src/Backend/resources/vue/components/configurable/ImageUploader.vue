<template>
    <v-layout>
        <v-flex md1>
            <z-file-picker
                :folder="folder"
                :visibility="visibility"
                file-type="image"
                @imageSelected="imageSelected"
            ></z-file-picker>
        </v-flex>
        <v-flex md5 v-if="!!innerValue">
            <v-img :src="innerValue"></v-img>
        </v-flex>
        <v-flex md6>
            <v-file-input
                label="Select upload file"
                filled
                show-size
                :accept="accept"
                :rules="rules"
                @change="fileChanged"
            ></v-file-input>
        </v-flex>
    </v-layout>
</template>

<script>
import FileUploader from "./FileUploader";
export default {
    extends: FileUploader,
    methods: {
        imageSelected(name) {
            console.log("imageSelected", name);
        }
    }
};
</script>
