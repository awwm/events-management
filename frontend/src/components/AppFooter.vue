<template>
  <v-footer app color="primary">
    <v-row class="text-center">
      <v-col>
        <span>&copy; {{ currentYear }} Event Management App. All rights reserved.</span>
      </v-col>
    </v-row>
  </v-footer>
</template>

<script>
export default {
  // Add component logic here if needed
  data() {
    return {
      currentYear: new Date().getFullYear() // Get current year dynamically
    };
  }
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
</style>