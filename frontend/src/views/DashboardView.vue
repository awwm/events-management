<template>
  <div class="dashboard">
    <h1>Welcome to the Dashboard!</h1>
    <!-- Button to open the modal -->
    <v-btn @click="openModal" color="primary">Add New Event</v-btn>
    <!-- Modal component -->
    <v-dialog v-model="modalOpen" max-width="600">
      <!-- Include the EventForm component inside the modal -->
      <EventForm @close-modal="closeModal"></EventForm>
    </v-dialog>
    <!-- Other content in the dashboard view -->
    <EventList :userId="userId" :publicPage="false" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import EventList from '@/components/EventList.vue';
import EventForm from '@/components/EventForm.vue';

export default {
  components: {
    EventForm,
    EventList
  },
  data() {
    return {
      modalOpen: false, // Variable to control the modal state
    };
  },
  methods: {
    openModal() {
      // Open the modal
      this.modalOpen = true;
    },
    closeModal() {
      // Close the modal
      this.modalOpen = false;
    },
  },
  computed: {
    ...mapGetters(['getUserEvents']), // Assuming you have a getter for user-specific events
    userId() {
      return this.$store.state.userId; // Get userId from store
    },
  },
  mounted() {
    // Fetch user-specific events for the dashboard
    if (!this.userEvents.length) {
      // Only fetch events if they are not already available in the store
      this.$store.dispatch('fetchUserEvents', this.userId); // Pass the userId if needed
    }
  },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>