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
    <EventList />
  </div>
</template>

<script>
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
  }
};
</script>

<style scoped>
/* Add your custom styles here */
</style>