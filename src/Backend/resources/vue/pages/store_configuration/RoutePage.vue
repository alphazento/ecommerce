<template>
    <v-layout>
        <v-flex md3>
            <v-expansion-panels accordion multiple>
                <v-expansion-panel>
                    <v-expansion-panel-header
                        text-left
                        class="assign-drawer-item"
                    >
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon large color="blue darken-2"
                                        >mdi-store</v-icon
                                    >
                                </v-btn>
                            </v-list-item-avatar>
                            <v-list-item-title>Store</v-list-item-title>
                        </v-list-item>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item>
                            <a href="/admin/configs">Configuration</a>
                        </v-list-item>
                        <v-list-item>
                            <a href="/admin/da">Dynamic Attributes</a>
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                    <v-expansion-panel-header
                        text-left
                        class="assign-drawer-item"
                    >
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon large color="blue darken-2"
                                        >mdi-warehouse</v-icon
                                    >
                                </v-btn>
                            </v-list-item-avatar>
                            <v-list-item-title>Catalog</v-list-item-title>
                        </v-list-item>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        content
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-flex>
        <v-flex md9>
            <v-expansion-panels accordion multiple>
                <v-expansion-panel>
                    <v-expansion-panel-header
                        text-left
                        class="assign-drawer-item"
                    >
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon large color="blue darken-2"
                                        >mdi-store</v-icon
                                    >
                                </v-btn>
                            </v-list-item-avatar>
                            <v-list-item-title>Store</v-list-item-title>
                        </v-list-item>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item>
                            <a href="/admin/configs">Configuration</a>
                        </v-list-item>
                        <v-list-item>
                            <a href="/admin/da">Dynamic Attributes</a>
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                    <v-expansion-panel-header
                        text-left
                        class="assign-drawer-item"
                    >
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon large color="blue darken-2"
                                        >mdi-warehouse</v-icon
                                    >
                                </v-btn>
                            </v-list-item-avatar>
                            <v-list-item-title>Catalog</v-list-item-title>
                        </v-list-item>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        content
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-flex>
    </v-layout>
</template>

<script>
export default {
    computed: {}
};
</script>
