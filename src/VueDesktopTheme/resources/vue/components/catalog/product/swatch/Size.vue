<template>
    <v-chip-group v-model="selection" column>
        <v-chip v-for="(size, i) in items" :key="i" :color="'pink'" outlined>
            <v-avatar left v-if="i === selection">
                <v-icon>mdi-checkbox-marked-circle</v-icon>
            </v-avatar>
            {{ size }}
        </v-chip>
    </v-chip-group>
</template>

<script>
export default {
    props: {
        items: {
            type: Array
        },
        current: {
            type: String
        },
        type: {
            type: String
        }
    },
    created() {
        let index = this.items.indexOf(this.current);
        this.selection = index < 0 ? undefined : index;
    },
    data() {
        return {
            selection: undefined,
            swatch: "size"
        };
    },
    watch: {
        selection(val, old) {
            if (val != old) {
                var value = undefined;
                if (val !== undefined && val > -1) {
                    value = this.items[val];
                }
                this.$emit("swatchSelected", {
                    swatch: this.type,
                    value: value
                });
            }
        }
    }
};
</script>
