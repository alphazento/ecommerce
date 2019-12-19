<template>
    <div>
        <!-- <v-app-bar hide-on-scroll> -->
        <v-app-bar app>
            <!-- logo -->
            <a href="/">
                <v-img :src="logo" :max-height="45" :contain="true"></v-img>
            </a>
            <!-- category menus -->
            <v-spacer></v-spacer>

            <!-- account -->
            <v-btn icon @click.stop="signin" v-if="!!user.is_guest">
                <v-icon color="grey">mdi-account-circle</v-icon>
            </v-btn>
        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            absolute
            :mini-variant.sync="mini"
            permanent
            class="fixed-position"
        >
         <v-list-item>
            <v-list-item-avatar>
                <v-btn icon>
                    <v-icon>mdi-dashboard</v-icon>
                </v-btn>
            </v-list-item-avatar>
            <v-list-item-title>Dashboard</v-list-item-title>
            <v-btn
                icon
                @click.stop="mini = !mini"
            >
                <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
        </v-list-item>

        </v-navigation-drawer>

        <!-- breadcump slot -->
    </div>
</template>

<script>
export default {
    props: {
        logo: {
            type: String
        }
    },
    data() {
        return {
            drawer: true,
            mini: false,
        };
    },

    methods: {
        onClick(e, item) {
            // this.$vuetify.goTo(item.href);
        },
    },
    computed: {
        user() {
            return this.$store.state.user;
        }
    }
};
</script>

