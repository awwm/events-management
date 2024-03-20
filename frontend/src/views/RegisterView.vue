<template>
    <v-container class="d-flex justify-center align-center">
        <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
                <h2 class="text-center">Register User</h2>
                <!-- Registration form -->
                <v-form v-if="!registrationSuccess" @submit.prevent="registerUser">
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
import { BASE_URL } from '../../constants.js'; // Import the BASE_URL constant

export default {
    data() {
        return {
            username: '',
            email: '',
            password: '',
            registrationSuccess: false,
            token: null // Store JWT token here
        };
    },
    methods: {
        async registerUser() {
            const userData = {
                username: this.username,
                email: this.email,
                password: this.password,
                register: true
            };

            try {
                const response = await fetch(BASE_URL + 'api/UserAPI/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.token // Include JWT token in headers
                    },
                    body: JSON.stringify(userData)
                });

                if (response.ok) {
                    // Registration successful
                    console.log('Registration successful');
                    this.registrationSuccess = true;
                    // Assuming the server returns a token upon registration, update the stored token
                    const data = await response.json(); // Parse the response body as JSON
                    this.token = data.token; // Update the stored token
                    localStorage.setItem('token', this.token); // Save the token to localStorage
                } else {
                    throw new Error('Registration failed');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    },
    created() {
        // Retrieve token when component is created
        this.token = localStorage.getItem('token');
    }
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
</style>
