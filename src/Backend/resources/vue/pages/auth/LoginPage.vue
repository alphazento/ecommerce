<template>
    <v-card class="elevation-12">
        <v-container>
            <v-toolbar flat color="#F2F2F2">
                <v-toolbar-title class="display-1">
                    LOGIN
                </v-toolbar-title>
                <v-spacer />
            </v-toolbar>
            <v-card-text>
                <p v-if="!!errorMessage" class="subtitle-1 red--text">
                    {{ errorMessage }}
                </p>
                <v-form ref="signin_form">
                    <v-text-field
                        v-model="email"
                        label="Email"
                        name="email"
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
                        name="password"
                        label="Password"
                        hint="At least 8 characters"
                        counter
                        @click:append="showPasswd = !showPasswd"
                    ></v-text-field>
                </v-form>
            </v-card-text>

            <v-card-actions>
                <v-container text-center class="no-padding">
                    <v-layout row>
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
                </v-container>
            </v-card-actions>
        </v-container>
    </v-card>
</template>

<script>

import { AUTH_REQUEST } from "../../store/actions"

export default {
    data() {
        return {
            showPasswd: false,
            email: "",
            fullname: "",
            password: "",
            confirm_password: "",
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
            this.$store.dispatch(AUTH_REQUEST, { username: this.email, password: this.password }).then(() => {
                this.$router.push("/admin");
            });
        },
        login1() {
            this.$store.dispatch("showSpinner", "Logging in...");
            axios
                .post("/api/v1/admin/oauth2/token", {
                    username: this.email,
                    password: this.password
                })
                .then(response => {
                    this.$store.dispatch("hideSpinner");
                    if (response.data.success) {
                        if (response.data.code == 200) {
                            localStorage.setItem(
                                "user-token",
                                response.data.data
                            );
                            resolve(response);
                            return;
                        }
                    }
                    this.errorMessage = response.data.data.message;
                })
                .catch(err => {
                    localStorage.removeItem("user-token"); // if the request fails, remove any possible user token if possible
                    reject(err);
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
