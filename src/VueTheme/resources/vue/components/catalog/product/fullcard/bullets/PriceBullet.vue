<template>
    <div class="my-4 subtitle-1 product__prices">
        <div class="product__special-price">
            ${{ price }}
        </div>
        <div>
            RRP:
            <s>
                <span class="product__rrp-price">
                    $1024.99
                </span>
            </s>
        </div>
        <div>
            You Save:
            <span class="product__price-saved">
                $1024.99 (%50)
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: Object,
        price: String | Number
    }  
};
</script>
