<template>
    <v-chip-group
        v-model="selection"
        column
    >
        <v-chip v-for="(color, i) in items" :key=i :color="cssColors[color]">
            <div :style="chipStype(color, String(i) == String(selection))">
                <v-avatar left v-if="String(i) == String(selection)" 
                >
                    <v-icon>mdi-checkbox-marked-circle</v-icon>
                </v-avatar>
                {{color}}
            </div>
        </v-chip>
        <input type="hidden" name="options[color]" v-model="items[selection]" />
    </v-chip-group>
</template>

<script>
import SizeSwatch from "./Size"
export default {
    extends: SizeSwatch,
    created() {
        let index =  this.items.indexOf(this.current);
        this.selection = index < 0 ? undefined : index;
        this.swatch = 'color';
    },
    computed: {
        cssColors() {
            return this.$store.state.swatches.color;
        }
    },
    methods: {
        invertColor(color) {
            color = color.substring(1); // remove #
            color = parseInt(color, 16); // convert to integer
            color = color < 0xFFFF80 ? 0xFFFFFF : 0x000000;
            color = color.toString(16); // convert to hex
            color = ("000000" + color).slice(-6); // pad with leading zeros
            color = "#" + color; // prepend #
            return color;
        },
        chipStype(color, active) {
            let hexTripletColor = this.cssColors[color];
            let textColor = this.invertColor(hexTripletColor);
            return {
                color: textColor 
            }
        }
    }
};
</script>
