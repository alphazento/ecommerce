<template>
    <v-chip-group
        v-model="selection"
        active-class="accent-4 white--text"
        column
        outlined
    >
        <v-chip v-for="(color, i) in items" :key=i :color="cssColors[color]">
            <v-avatar left v-if="i=== selection">
                <v-icon>mdi-checkbox-marked-circle</v-icon>
            </v-avatar>
            {{color}}
        </v-chip>
    </v-chip-group>
</template>

<script>
import SizeSwatch from "./Size"
export default {
    extends: SizeSwatch,
    computed: {
        cssColors() {
            return this.$store.state.swatches.color;
        }
    }
};
</script>
