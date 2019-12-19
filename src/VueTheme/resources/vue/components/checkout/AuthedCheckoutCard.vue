<template>
    <v-container>
        <v-layout
            class="row"
            v-if="cart && cart.items && cart.items.length > 0"
        >
            <v-flex md4 xs12>
                <checkout-cart-card></checkout-cart-card>
            </v-flex>

            <v-flex md8 xs12>
                <v-stepper v-model="step" vertical>
                    <v-stepper-step :complete="step > 1" step="1">
                        <v-layout class="step-header">
                            <v-flex md8>Delivery Address</v-flex>
                            <v-flex v-if="step > 2" md4 class="text-right">
                                <a @click="step = 2">Edit</a>
                            </v-flex>
                        </v-layout>
                    </v-stepper-step>
                    <v-stepper-content step="1">
                        <checkout-address-card
                            :fullname="fullname"
                            :address="cart.shipping_address"
                            :complete="step > 2"
                            :step="2"
                            v-on:childMessage="getChildMessage"
                        >
                        </checkout-address-card>
                    </v-stepper-content>

                    <v-stepper-step :complete="step > 2" step="2"
                        >Payment Options</v-stepper-step
                    >
                    <v-stepper-content step="2">
                        <checkout-payment-card
                            :complete="step > 2"
                            :step="3"
                            v-on:childMessage="getChildMessage"
                        ></checkout-payment-card>
                    </v-stepper-content>
                </v-stepper>
            </v-flex>
        </v-layout>

        <v-layout
            class="row"
            v-if="!cart || !cart.items || cart.items.length == 0"
        >
            <v-flex md12 text-center>
                <div class="empty-shopping-cart">
                    <p class="title">Shopping Cart is Empty</p>
                    <p>You have no items in your shopping cart.</p>
                    <p>Click <a href="/">here</a> to continue shopping</p>
                </div>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import GuestCheckoutCard from "./GuestCheckoutCard"
export default {
    extends: GuestCheckoutCard,
};
</script>
