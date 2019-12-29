<template>
    <span class="subtitle-1">
        {{ selectedValue }}
    </span>
</template>

<script>
export default {
    props: {
        value: {
            type: String | Number
        },
        options: {
            type: Array
        }
    },
    computed: {
        selectedValue() {
            let items = this.options.filter(item => {
                return item.value === this.value;
            });

            if (items && items.length > 0) {
                return items[0].label;
            }
            return "";
        }
    }
};
</script>
