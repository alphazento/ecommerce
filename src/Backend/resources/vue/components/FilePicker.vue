<template>
    <v-container>
        <v-menu :close-on-content-click="false" offset-y>
            <template v-slot:activator="{ on }">
                <v-btn icon dark v-on="on">
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
                        style="max-width: 600px;"
                        placeholder="Search..."
                        @keyup.native="onEnterKey"
                        class="d-none d-md-block"
                        append-icon="mdi-magnify"
                    />
                    <v-pagination
                        circle
                        :length="3"
                        v-model="page"
                        :total-visible="5"
                    ></v-pagination>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row>
                            <v-col
                                v-for="(item, i) of items"
                                :key="i"
                                class="d-flex child-flex"
                                cols="4"
                            >
                                <v-card flat tile class="d-flex">
                                    <v-img
                                        :src="item.url"
                                        :lazy-src="
                                            `https://picsum.photos/10/6?image=15`
                                        "
                                        aspect-ratio="1"
                                        class="grey lighten-2"
                                    >
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
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-menu>
    </v-container>
</template>

<script>
export default {
    props: {
        page: Number | String,
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
            searchText: "",
            pagination: {
                data: [],
                from: 1,
                to: 1,
                last_page: 1,
                total: 1,
                per_page: 9,
                local_pagination: false
            },
            api: `${this.server}/files-finder/${this.visibility}/${this.folder}`
        };
    },
    mounted() {
        this.loadPage(1);
    },
    methods: {
        loadPage(page) {
            axios
                .get(
                    `${this.api}?text=${this.searchText}&page=${page}&type=${this.fileType}`
                )
                .then(response => {
                    this.items = response.data.data;
                });
        },
        onEnterKey(e) {
            // if (e.isTrusted && e.code === "Enter" && this.canSearch()) {
            if (e.isTrusted && e.code === "Enter") {
                this.loadPage(1);
            }
        }
    },
    watch: {
        page: function(val, oldVal) {
            this.loadPage(this.page);
        }
    }
};
</script>
