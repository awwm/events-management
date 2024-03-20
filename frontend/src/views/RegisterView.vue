<template>
    <v-container class="d-flex justify-center align-center">
        <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
                <h2 class="text-center">Register User</h2>
                <!-- Registration form -->
                <v-form v-if="!registrationSuccess" @submit.prevent="submitRegistration">
                    <!-- Form fields -->
                    <v-text-field v-model="username" label="Username" required></v-text-field>
                    <v-text-field v-model="email" label="Email" type="email" required></v-text-field>
                    <v-text-field v-model="password" label="Password" type="password" required></v-text-field>
                    <!-- Submit button -->
                    <v-btn type="submit" color="primary" block>Register</v-btn>
                </v-form>
                <!-- Success message -->
                <v-alert v-if="registrationSuccess" type="success" outlined>
                    User registered successfully. <!-- Display success message -->
                </v-alert>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapActions } from 'vuex'; // Import mapActions from Vuex

export default {
    data() {
        return {
            username: '',
            email: '',
            password: '',
            registrationSuccess: false,
        };
    },
    methods: {
        ...mapActions(['registerUser']), // Map the registerUser action from Vuex
        async submitRegistration() {
            try {
                const response = await this.$store.dispatch('registerUser', {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    register: true // Include the 'register' flag
                });
                // Optionally handle successful sign-in
                if (response.ok) {
                    // Registration successful
                    this.registrationSuccess = true;
                    const data = await response.json();
                    localStorage.setItem('token', data.token);
                } else {
                    // Registration failed
                    console.error('Registration failed:', response.statusText);
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

