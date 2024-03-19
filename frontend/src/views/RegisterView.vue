<template>
    <v-container class="d-flex justify-center align-center">
        <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
                <h2 class="text-center">Register User</h2>
                <!-- Registration form -->
                <v-form @submit.prevent="registerUser">
                    <!-- Form fields -->
                    <v-text-field v-model="username" label="Username" required></v-text-field>
                    <v-text-field v-model="email" label="Email" type="email" required></v-text-field>
                    <v-text-field v-model="password" label="Password" type="password" required></v-text-field>
                    <!-- Submit button -->
                    <v-btn type="submit" color="primary" block>Register</v-btn>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            username: '',
            email: '',
            password: ''
        };
    },
    methods: {
        registerUser() {
            // Implement registration logic here
        }
    }
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
</style>