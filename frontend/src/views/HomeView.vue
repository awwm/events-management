<template>
  <div class="home-view">
    <HeroSection />
    <EventList :publicEvents="publicEvents" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import HeroSection from '../components/HeroSection.vue';
import EventList from '../components/EventList.vue';

export default {
  name: 'HomeView',

  components: {
    HeroSection,
    EventList,
  },

  computed: {
    ...mapGetters(['getEvents']), // All events
    publicEvents() {
      return this.getEvents;
    },
  },

  mounted() {
    // Fetch events
    if (!this.publicEvents.length) {
      // Only fetch events if they are not already available
      this.$store.dispatch('fetchEvents');
    }
  },

  created() {
    // Dispatch the initializeDatabase action when the component is created
    this.$store.dispatch('initializeDatabase')
      .then(() => {
        console.log('Database initialization successful');
        // Optionally, you can perform additional actions after database initialization
      })
      .catch(error => {
        console.error('Error initializing database:', error);
      });
  },
};
</script>

<style scoped>
/* Add your CSS styles for the home view here */
</style>
