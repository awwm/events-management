<template>
    <v-container class="d-flex justify-center align-center">
        <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
                <h2>Sign In</h2>
                <!-- Signin form -->
                <v-form @submit.prevent="signinUser">
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
import { BASE_URL } from '../../constants.js'; // Import the BASE_URL constant

export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        async signinUser() {
            try {
                const response = await fetch(BASE_URL + '/api/UserAPI/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: this.email,
                        password: this.password
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    // Handle successful sign-in
                    // For example, store JWT token in local storage
                    localStorage.setItem('token', data.token);
                    // Redirect or navigate to the dashboard or another page
                    this.$router.push('/about');
                } else {
                    // Handle sign-in error
                    console.error('Sign-in failed');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
</style>
