<template>
    <v-container>
        <v-layout class="row">
            <v-flex md4 xs12 class="d-none d-md-block">
                <v-container>
                    <slot></slot>
                </v-container>
            </v-flex>
            <v-flex md8 xs12>
                <v-container>
                    <v-layout class="row">
                        <v-flex md6 xs8>
                            <h1>
                                {{ pageData.title }}
                            </h1>
                            <div v-html="pageData.description"></div>
                        </v-flex>
                        <v-flex md6 class="d-none d-md-block">
                            <sort-control></sort-control>
                        </v-flex>
                        <v-flex xs4 class="d-md-none v-middle">
                            <v-menu
                                v-model="mobile_filter_panel"
                                :close-on-content-click="false"
                                :nudge-width="300"
                                offset-x
                            >
                                <template v-slot:activator="{ on }">
                                    <v-btn
                                        color="indigo"
                                        text-right
                                        dark
                                        v-on="on"
                                    >
                                        <v-icon>mdi-filter</v-icon>Filter&Sort
                                    </v-btn>
                                </template>
                                <v-system-bar
                                    dark
                                    color="red lighten-2"
                                    height="35"
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        text
                                        @click="mobile_filter_panel = false"
                                    >
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </v-system-bar>
                                <slot></slot>
                            </v-menu>
                        </v-flex>
                    </v-layout>
                </v-container>
                <product-grid
                    :dataset="searchResult"
                    :flex="'md4 xs6'"
                ></product-grid>
                <z-pagination></z-pagination>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            mobile_filter_panel: false
        };
    },
    computed: {
        searchResult() {
            return this.$store.state.searchResult;
        },
        pageData() {
            return this.$store.state.pageData;
        }
    }
};
</script>
