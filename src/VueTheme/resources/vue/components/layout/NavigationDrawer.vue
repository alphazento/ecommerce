<template>
    <v-list dense nav>
        <v-list-item>
            <v-list-item-avatar>
                <v-icon color="grey">mdi-account</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title>
                    <a v-if="!user.is_guest" href="/my-account">Account</a>
                    <a
                        v-if="!!user.is_guest"
                        @click="signin($event)"
                        href="/login"
                    >
                        Login
                    </a>
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item v-if="!user.is_guest">
            <v-list-item-content>
                <v-list-item-title>
                    <a href="/my-account/orders">
                        Orders
                    </a>
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item v-if="!user.is_guest">
            <v-list-item-content>
                <v-list-item-title>
                    <a href="/my-account/by-again">
                        Buy Again
                    </a>
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title><a href="/">Home</a></v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <slot> </slot>
    </v-list>
</template>

<script>
export default {
    computed: {
        user() {
            return this.$store.state.user;
        }
    },
    methods: {
        signin(event) {
            event && event.preventDefault();
            this.$emit("signin");
        }
    }
};
</script>
