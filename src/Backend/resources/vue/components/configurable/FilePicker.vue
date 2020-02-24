<template>
  <v-container>
    <v-menu :close-on-content-click="false" offset-y v-model="show">
      <template v-slot:activator="{ on, value }">
        <v-btn icon dark v-on="on" @click="onLibClick(value)">
          <v-icon large color="deep-purple">mdi-dots-horizontal-circle</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span>Select/Upload File to Folder "{{folder}}", visibility:{{visibility}}</span>
        </v-card-title>
        <v-card-text>
          <v-container fluid>
            <v-layout row>
              <v-flex md7>
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
              </v-flex>
              <v-flex md3 v-if="chosenFile">
                <v-btn @click="uploadFile">Upload</v-btn>
              </v-flex>
              <v-flex md3 v-if="uploading">
                <v-progress-circular indeterminate size="48" width="2" color="light-blue"></v-progress-circular>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-text-field
                v-model="searchText"
                hide-details
                style="width: 600px;"
                placeholder="Search..."
                clearable
                @keyup.native="onEnterKey"
                @blur="onBlur"
                @click:clear="clearSearch"
                class="d-none d-md-block"
                append-icon="mdi-magnify"
              />
              <v-pagination circle :length="pagination.last_page" v-model="page" :total-visible="5"></v-pagination>
            </v-layout>
            <v-layout v-if="dataLoaded">
              <v-container fluid>
                <v-row>
                  <v-col v-for="(item, i) of items" :key="i" class="d-flex child-flex" cols="4">
                    <v-card flat tile class="d-flex card-hover" @click="selectFile(item)">
                      <v-img
                        :src="item.thumbnail"
                        aspect-ratio="1"
                        class="grey lighten-2 align-end"
                      >
                        <v-card-title class="title white--text primary" v-text="item.name">
                        </v-card-title>
                        <template v-slot:placeholder>
                          <v-row class="fill-height ma-0" align="center" justify="center">
                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                          </v-row>
                        </template>
                      </v-img>
                    </v-card>
                  </v-col>
                </v-row>
              </v-container>
            </v-layout>
            <v-layout class="text-center" v-else>
              <v-progress-circular indeterminate size="96" width="4" color="light-blue"></v-progress-circular>
            </v-layout>
          </v-container>
        </v-card-text>
      </v-card>
    </v-menu>
  </v-container>
</template>

<script>
import FileUploader from "./FileUploader";
export default {
  extends: FileUploader,
  props: {
    fileType: {
      type: String,
      default: "*"
    },
    server: {
      type: String,
      default: "/api/v1/admin"
    }
  },
  data() {
    return {
      show: false,
      page: 1,
      dataLoaded: false,
      searchText: "",
      oldSearchText: "",
      pagination: {
        data: [],
        from: 1,
        to: 1,
        last_page: 1,
        total: 1,
        per_page: 9,
        current_page: 1,
        local_pagination: false
      },
      api: `${this.server}/files-finder/${this.visibility}/${this.folder}`
    };
  },
  computed: {
    items() {
      if (this.pagination.local_pagination) {
        let its = this.pagination.data.slice(
          this.pagination.from - 1,
          this.pagination.to
        );
        return its;
      }
      return this.pagination.data;
    }
  },
  methods: {
    loadPage(page) {
      if (this.searchText === null) {
        this.searchText = "";
      }

      this.dataLoaded = false;
      axios
        .get(
          `${this.api}?text=${this.searchText}&page=${page}&type=${this.fileType}`
        )
        .then(response => {
          this.pagination = response.data.data;
          this.dataLoaded = true;
        });
      this.oldSearchText = this.searchText;
    },
    onEnterKey(e) {
      // if (e.isTrusted && e.code === "Enter" && this.canSearch()) {
      if (e.isTrusted && e.code === "Enter") {
        // if (this.searchText.length > 2) {
        if (this.searchText !== this.oldSearchText) {
          this.loadPage(1);
        }
      }
    },
    onBlur() {
      if (this.searchText !== this.oldSearchText) {
        this.loadPage(this.page);
      }
    },
    onLibClick(isOn) {
      if (!this.isOn && !this.dataLoaded) {
        this.loadPage(1);
      }
    },
    clearSearch() {
      this.searchText = "";
      this.oldSearchText = "";
      this.loadPage(1);
    },
    selectFile(item) {
      this.$emit("fileSelected", item);
      this.show = false;
    },
    fileuploaed(data) {
      this.pagination.data.unshift(data);
      this.pagination.to++;
    }
  },
  watch: {
    page: function(val, oldVal) {
      if (this.pagination.local_pagination) {
        this.pagination.current_page = this.page;
        this.pagination.from += 9;
        this.pagination.to += 9;
        if (this.pagination.to > this.pagination.total) {
          this.pagination.to = $total;
        }
      } else {
        this.loadPage(this.page);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.card-hover {
  cursor: pointer;
  &:hover {
    border: 3px solid rebeccapurple;
  }
}
</style>
