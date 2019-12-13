<template>
    <v-list>
        <v-list-item v-if="applied.length > 0">
            <v-chip
                class="ma-2"
                close
                color="teal"
                text-color="white"
                v-for="(item, i) in applied"
                :key="i"
                @click="removeFilter(item)"
                @click:close="removeFilter(item)"
            >
                {{ item.label }}
            </v-chip>
        </v-list-item>

        <v-list-item v-for="(item, i) in items" :key="i">
            <v-list-item-action>
                <v-switch
                  v-model="item.switch" 
                  v-on:change="addFilter(item)"
                  color="purple"
                ></v-switch>
            </v-list-item-action>
            <v-list-item-title
                >{{ item.label }}({{ item.amount }})</v-list-item-title
            >
        </v-list-item>
    </v-list>
</template>

<script>
import DynamicAttributeFilterBullet from './DynamicAttributeFilterBullet'

export default {
    extends: DynamicAttributeFilterBullet,
    methods: {
        addFilter(item) {
            this.applied_ids.push(item.id);
            this.$emit('filterChange', { filter: this.searchKey, data: this.applied_ids });
        },
        removeFilter(item) {
            var index = this.applied_ids.indexOf(Number(item.id));
            if (index > -1) {
                this.applied_ids.splice(index, 1);
                this.$emit('filterChange', { filter: this.searchKey, data: this.applied_ids });
            }
        },
        mapAppliedIds() {
            return this.applied.map(item => {
                return Number(item.id);
            });
        }
    },
    watch: {
      applied(newVal, oldVal) {
          // watch it
          this.applied_ids = this.mapAppliedIds();
      }
    }
};
</script>
