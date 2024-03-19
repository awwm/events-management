<template>
  <v-app-bar app color="primary" class="px-4">
    <!-- Link to the homepage -->
    <router-link to="/" class="router-link">
      <v-toolbar-title>Event Management App</v-toolbar-title>
    </router-link>
    <!-- Navigation buttons -->
    <v-spacer></v-spacer>
    <v-btn v-if="!isLoggedIn" @click="navigateTo('/register')">Register</v-btn>
    <v-btn v-if="!isLoggedIn" @click="navigateTo('/signin')">SignIn</v-btn>
    <v-btn v-if="isLoggedIn" @click="logout">Logout</v-btn>
  </v-app-bar>
</template>

<script>
export default {
  props: {
    isLoggedIn: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    navigateTo(route) {
      this.$router.push(route);
    },
    logout() {
      // Implement logout logic here
    }
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