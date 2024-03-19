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
export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        signinUser() {
            // Implement signin logic here
            // Send signin data to backend API
        }
    }
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
</style>