<template>
  <v-layout>
    <v-flex md9>
      <v-file-input
        label="Select upload file"
        filled
        show-size
        :accept="accept"
        :rules="rules"
        v-model="chosenFile"
        :success="success"
        :success-messages="success_message"
        @change="fileChanged"
      ></v-file-input>
      <v-btn v-if="chosenFile" large color="primary"  @click="uploadFile">Upload</v-btn>
    </v-flex>
    <v-flex md3 v-if="uploading">
      <v-progress-circular indeterminate size="48" width="2" color="light-blue"></v-progress-circular>
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
      uploading: false,
      chosenFile: null,
      success: false,
      success_message: "",
      max_size: this.maxSize * 1024 * 1024,
      rules: [
        value =>
          !value ||
          value.size < this.max_size ||
          "Avatar size should be less than " + this.maxSize + " MB!"
      ]
    };
  },
  methods: {
    fileChanged() {
      this.success = false;
      this.success_message = '';
    }, 
    uploadFile() {
      let file = this.chosenFile;
      if (file.size > this.max_size) {
        return;
      }
      let formData = new FormData();
      formData.append("file0", file);
      this.uploading = true;
      this.success = false;
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
          this.uploading = false;
          this.chosenFile = null;
          this.success = true;
          this.success_message = `${file.name} uploaded.`;
          this.fileuploaed(response.data.data);
        })
        .catch(function() {
          console.log("FAILURE!!");
          this.uploading = false;
          this.success = false;
        });
    },

    fileuploaed(data) {
        this.$emit('fileuploaed', response.data.data);
    }
  }
};
</script>
