<template>
  <v-app-bar app color="primary" class="px-4">
    <!-- Link to the homepage -->
    <router-link to="/" class="router-link">
      <v-toolbar-title>Event Management App</v-toolbar-title>
    </router-link>
    <!-- Navigation buttons -->
    <v-spacer></v-spacer>
    <v-btn v-if="!isAuthenticated" @click="navigateTo('/register')">Register</v-btn>
    <v-btn v-if="!isAuthenticated" @click="navigateTo('/signin')">SignIn</v-btn>
    <v-btn v-if="isAuthenticated" @click="navigateTo('/dashboard')">Dashboard</v-btn>
    <v-btn v-if="isAuthenticated" @click="logout">Logout</v-btn>
  </v-app-bar>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
  methods: {
    ...mapActions(['logoutUser']),
    navigateTo(route) {
      this.$router.push(route);
    },
    async logout() {
      await this.logoutUser();
      // Emit an event to notify the parent component
      this.$emit('userLoggedOut');
    }
  },
  computed: {
    ...mapState(['isAuthenticated'])
  }
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
.router-link {
  text-decoration: none;
  /* Remove underline from router-link */
  color: inherit;
  /* Inherit color from parent */
  cursor: pointer;
  /* Change cursor to pointer on hover */
}
</style>