<template>
    <v-container class="d-flex justify-center align-center">
        <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
                <h2>Sign In</h2>
                <!-- Signin form -->
                <v-form @submit.prevent="signInUser">
                    <!-- Form fields -->
                    <v-text-field v-model="email" label="Email" type="email" required></v-text-field>
                    <v-text-field v-model="password" label="Password" type="password" required></v-text-field>
                    <!-- Submit button -->
                    <v-btn type="submit" color="primary">Sign In</v-btn>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapActions } from 'vuex'; // Import mapActions from Vuex

export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        ...mapActions(['signinUser', 'setAuthenticated']), // Map the signInUser action from Vuex
        async signInUser() {
            try {
                const response = await this.$store.dispatch('signinUser', {
                    email: this.email,
                    password: this.password
                });
                // Optionally handle successful sign-in
                if (response.ok) {
                    // Registration successful
                    this.registrationSuccess = true;
                    const data = await response.json();
                    localStorage.setItem('token', data.token);
                    // Set isAuthenticated to true in Vuex store
                    this.setAuthenticated(true);
                    this.$router.push('/dashboard');
                } else {
                    // Registration failed
                    console.error('Login failed:', response.statusText);
                }
            } catch (error) {
                console.error('Error signing in:', error);
                // Optionally handle sign-in errors
            }
        }
    },
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
</style>
