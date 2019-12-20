<template>
    <v-overlay
        :absolute="spinnerOverlay.absolute"
        :opacity="spinnerOverlay.opacity"
        :value="spinnerOverlay.overlay"
        z-index="99999"
    >
        <div class="text-center ma-12">
            <v-progress-circular
                :indeterminate="indeterminate"
                :size="size"
                :width="width"
                color="light-blue"
            >
            </v-progress-circular>
        </div>
        <div class="text-center ma-12">
            {{ spinnerOverlay.text }}
        </div>
    </v-overlay>
</template>

<script>
export default {
    data: () => ({
        indeterminate: true,
        size: 96,
        width: 4
    }),
    computed: {
        spinnerOverlay() {
            return this.$store.state.spinnerOverlay;
        }
    }
};
</script>
