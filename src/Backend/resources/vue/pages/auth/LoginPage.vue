<template>
    <v-container>
        <v-card flat class="elevation-12">
            <v-card-title>
                LOGIN
            </v-card-title>
            <v-card-text>
                <p v-if="!!errorMessage" class="subtitle-1 red--text">
                    {{ errorMessage }}
                </p>
                <v-form ref="signin_form">
                    <v-text-field
                        v-model="username"
                        label="Email"
                        name="username"
                        prepend-icon="mdi-account"
                        type="text"
                        :rules="[rules.clear, rules.required, rules.email]"
                    />
                    <v-text-field
                        v-model="password"
                        prepend-icon="mdi-lock"
                        :append-icon="showPasswd ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.clear, rules.required, rules.min]"
                        :type="showPasswd ? 'text' : 'password'"
                        name="current-password"
                        label="Password"
                        hint="At least 8 characters"
                        counter
                        @click:append="showPasswd = !showPasswd"
                        autocomplete
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions flat>
                <v-layout row text-center class="no-padding">
                    <v-flex md12>
                        <v-btn
                            class="btn__full"
                            large
                            color="primary"
                            @click="submit"
                            >Login</v-btn
                        >
                    </v-flex>
                </v-layout>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>

import { AUTH_REQUEST } from "../../store/actions"

export default {
    data() {
        return {
            showPasswd: false,
            username: "",
            password: "",
            errorMessage: "",
            rules: {
                clear: v => (this.errorMessage = "") || true,
                required: value => !!value || "Required Field.",
                min: v => (v && v.length >= 8) || "Min 8 characters",
                email: v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            }
        };
    },
    methods: {
        login() {
            this.$store.dispatch(AUTH_REQUEST, { username: this.username, password: this.password }).then(() => {
                this.$router.push("/admin");
            }).catch(err => {
                this.errorMessage = err;
            });
        },
        submit() {
            if (this.$refs.signin_form.validate()) {
                this.login();
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.btn__full {
    width: 80% !important;
    min-width: 250px !important;
}
.bigger-message_display {
    .v-messages__wrapper {
        font-size: 24px !important;
    }
}
</style>
