<template>
    <v-layout>
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
import BaseConfig from "./Base";
export default {
    extends: BaseConfig,
    props: {
        maxSize: {
            type: Number,
            default: 20
        },
        visibility: {
            type: String,
            default: "public"
        },
        folder: {
            type: String,
            default: ""
        },
        accept: {
            type: String
        }
    },

    data() {
        return {
            max_size: this.maxSize * 1024 * 1024,
            rules: [
                value =>
                    !value ||
                    value.size < this.max_size ||
                    "Avatar size should be less than " + this.maxSize + " MB!"
            ]
        };
    },

    mounted() {
        console.log("domain", window.location.hostname);
    },
    methods: {
        fileChanged(file) {
            if (file.size > this.max_size) {
                return;
            }
            let formData = new FormData();
            formData.append("file0", file);
            axios
                .post(
                    `/api/v1/admin/upload/${this.visibility}/${this.folder}`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    }
                )
                .then(response => {
                    this.innerValue = response.data.data.url;
                    this.valueChanged();
                })
                .catch(function() {
                    console.log("FAILURE!!");
                });
        }
    }
};
</script>
