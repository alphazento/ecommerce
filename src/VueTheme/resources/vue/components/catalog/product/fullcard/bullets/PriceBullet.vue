<template>
    <div class="my-4 subtitle-1">
        <p class="special-price">
            ${{ product.prices.price }}
        </p>
        <div>
            RRP:
            <s>
                <span class="raw-price">
                    $1024.99
                </span>
            </s>
        </div>
        <div>
            You Save:
            <span class="raw-price">
                $1024.99
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: {
            type: Object
        }
    }  
};
</script>
