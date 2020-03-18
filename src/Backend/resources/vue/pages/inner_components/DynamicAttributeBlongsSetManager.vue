<template>
    <v-expansion-panels accordion multiple focusable v-if="current_id > 0">
        <v-expansion-panel>
            <v-expansion-panel-header text-left
                >Belongs To Dynamic Attribute Sets
            </v-expansion-panel-header>
            <v-expansion-panel-content>
                <v-container>
                    <v-layout row>
                        <v-flex
                            md4
                            v-for="(item, id) of set_checked_mapping"
                            :key="id"
                        >
                            <v-checkbox
                                v-model="item.checked"
                                :label="item.name"
                                @change="valueChanged(id)"
                            ></v-checkbox>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-expansion-panels>
</template>

<script>
// Manage Attribute belongs to many Attribute sets
export default {
    props: {
        model: String,
        id: Number
    },
    data() {
        return {
            sets: [],
            set_checked_mapping: {},
            current_attribute: { id: -1 },
            current_id: this.id
        };
    },
    methods: {
        fetchModelAttributeSets() {
            this.$store.dispatch("SHOW_SPINNER", "Fetching attributes...");
            return axios
                .get(
                    `/api/v1/admin/dynamic-attribute-sets/models/${this.model}`
                )
                .then(response => {
                    this.$store.dispatch("HIDE_SPINNER");
                    if (response && response.success) {
                        this.sets = response.data;
                    }
                    this.$store.dispatch("HIDE_SPINNER");
                    if (this.current_id) {
                        this.fetchAttribute();
                    }
                });
        },

        fetchAttribute() {
            this.$store.dispatch("SHOW_SPINNER", "Fetching attribute...");
            axios
                .get(`/api/v1/admin/dynamic-attributes/${this.current_id}/sets`)
                .then(response => {
                    if (response.success) {
                        this.current_attribute = response.data;
                        var mapping = {};
                        this.sets.forEach(item => {
                            mapping[item.id] = {
                                name: item.name,
                                checked: false
                            };
                        });
                        this.current_attribute.sets.forEach(item => {
                            mapping[item.id].checked = true;
                        });
                        this.set_checked_mapping = mapping;
                    }
                    this.$store.dispatch("HIDE_SPINNER");
                });
        },
        valueChanged(id) {
            let url = `/api/v1/admin/dynamic-attribute-sets/${id}/attributes/${this.current_id}`;
            let method = this.set_checked_mapping[id].checked
                ? "put"
                : "delete";
            this.$store.dispatch("SHOW_SPINNER", "Updating...");
            axios[method](url).then(response => {
                this.$store.dispatch("HIDE_SPINNER");
                if (response.success) {
                    this.$store.dispatch(
                        "snackMessage",
                        "Assigned to Attribute Set"
                    );
                } else {
                    this.$store.dispatch(
                        "snackMessage",
                        "Removed from Attribute Set"
                    );
                }
            });
        }
    },
    mounted() {
        if (this.model) {
            this.fetchModelAttributeSets();
        }
    },
    watch: {
        id(nV, oV) {
            this.current_id = nV;
            this.fetchAttribute();
        },
        model(nV, oV) {
            this.current_id = 0;
            this.fetchModelAttributeSets();
        }
    }
};
</script>
