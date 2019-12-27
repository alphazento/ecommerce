<template>
    <v-container>
        <v-menu :close-on-content-click="false" offset-y v-model="show">
            <template v-slot:activator="{ on, value }">
                <v-btn icon dark v-on="on" @click="onLibClick(value)">
                    <v-icon large color="deep-purple">
                        mdi-image-multiple
                    </v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <v-text-field
                        v-model="searchText"
                        hide-details
                        style="width: 600px;"
                        placeholder="Search..."
                        @keyup.native="onEnterKey"
                        class="d-none d-md-block"
                        append-icon="mdi-magnify"
                    />
                    <v-pagination
                        circle
                        :length="pagination.last_page"
                        v-model="page"
                        :total-visible="5"
                    ></v-pagination>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-layout>
                            <v-flex
                                v-for="(item, i) of items"
                                :key="i"
                                class="d-flex child-flex"
                                md4
                            >
                                <v-card
                                    flat
                                    tile
                                    class="d-flex card-hover"
                                    @click="selectFile(item)"
                                >
                                    <v-img
                                        :src="item.thumbnail"
                                        :lazy-src="
                                            'https://picsum.photos/10/6?image=15'
                                        "
                                        aspect-ratio="1"
                                        class="grey lighten-2 align-end "
                                    >
                                        <v-card-title
                                            class="title white--text"
                                            v-text="item.name"
                                        ></v-card-title>
                                        <template v-slot:placeholder>
                                            <v-row
                                                class="fill-height ma-0"
                                                align="center"
                                                justify="center"
                                            >
                                                <v-progress-circular
                                                    indeterminate
                                                    color="grey lighten-5"
                                                ></v-progress-circular>
                                            </v-row>
                                        </template>
                                    </v-img>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-menu>
    </v-container>
</template>

<script>
export default {
    props: {
        visibility: {
            type: String,
            default: "public"
        },
        folder: {
            type: String,
            default: ""
        },
        fileType: {
            type: String,
            default: ""
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
            axios
                .get(
                    `${this.api}?text=${this.searchText}&page=${page}&type=${this.fileType}`
                )
                .then(response => {
                    this.pagination = response.data.data;
                    this.dataLoaded = true;
                });
        },
        onEnterKey(e) {
            // if (e.isTrusted && e.code === "Enter" && this.canSearch()) {
            if (e.isTrusted && e.code === "Enter") {
                // if (this.searchText.length > 2) {
                this.loadPage(1);
                // }
            }
        },
        onLibClick(isOn) {
            if (!this.isOn && !this.dataLoaded) {
                this.loadPage(1);
            }
        },
        selectFile(item) {
            this.$emit("fileSelected", item);
            this.show = false;
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
