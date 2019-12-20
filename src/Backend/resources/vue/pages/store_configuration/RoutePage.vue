<template>
    <v-layout>
        <v-flex md3>
            <v-expansion-panels accordion multiple v-if="menus">
                <v-expansion-panel v-for="(item, name) in menus" :key="name">
                    <v-expansion-panel-header
                        text-left
                    >
                        {{item.title}}
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item v-for="(subItem, subName) in item.items" :key="subName">
                            <a @click.stop="fetchDetails(name, subName)">{{subItem.title}}</a>
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-flex>
        <v-flex md9>
            <v-expansion-panels accordion multiple>
                <v-expansion-panel v-for="(item, name) in groupData" :key="name">
                    <v-expansion-panel-header
                        text-left
                    >
                        {{item.title}}
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item v-for="(subItem, subName) in item.items" :key="subName">
                            <v-layout class="bottom-line">
                                <v-flex md3 class="v-middle">
                                    <span>{{subItem.title}}</span>
                                </v-flex>
                                <v-flex md6>
                                    <component :is="subItem.ui" v-bind="subItem" @valueChanged="configValueChanged"></component>
                                </v-flex>
                                <v-flex md3>
                                    {{subItem.description}}
                                </v-flex>
                            </v-layout>
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-flex>
    </v-layout>
</template>

<script>
export default {
    data() {
        return {
            dataKey: "store_config_menus",
            menus: undefined,
            groupData: {}
        }
    },
    created() {
        this.calcMenus();
        if (this.menus === undefined) {
            this.fetchMenus()
        }
    },
    methods: {
        calcMenus() {
            if (this.$store.state.cachedData.store_config_menus !== undefined) {
                this.menus = this.$store.state.cachedData.store_config_menus;
            }
        },
        fetchMenus() {
            this.$store.dispatch('showSpinner', "Loading configurations")
            axios.get('/api/v1/admin/configs/menus').then(response => {
                this.$store.dispatch('hideSpinner')
                if (response.data && response.data.success) {
                    this.$store.dispatch('cacheData', {store_config_menus: response.data.data});
                    this.calcMenus();
                } else {
                    this.groupData = {};
                }
            });
        },
        fetchDetails(name, subName) {
            this.$store.dispatch('showSpinner', "Loading details");
            axios.get(`/api/v1/admin/configs/groups/${name}/${subName}`).then(response => {
                this.$store.dispatch('hideSpinner')
                if (response.data && response.data.success) {
                    this.groupData = response.data.data;
                }
            });
        },
        configValueChanged(item) {
            this.$store.dispatch('showSpinner', "Updating...");
            axios.post(`/api/v1/admin/configs/${item.accessor}`, {
                value: item.value
            }).then(response => {
                this.$store.dispatch('hideSpinner');
            });
        }
    }
};
</script>

<style scoped>
.v-middle {
    margin-top: auto;
    margin-bottom: auto;
}
.bottom-line {
    border-bottom: 1px solid grey;
}

</style>