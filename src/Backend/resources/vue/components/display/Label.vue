<template>
    <span class="subtitle-1">
        {{ value }}
    </span>
</template>

<script>
export default {
    props: {
        value: {
            type: String | Number
        }
    }
};
</script>
