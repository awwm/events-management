<template>
    <div>
        <h2>Event List</h2>
        <div v-for="event in events" :key="event.id">
            <!-- Display event details here -->
            <p>{{ event.name }}</p>
            <!-- Add more details as needed -->
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    computed: {
        ...mapGetters(['getEvents']),
        events() {
            return this.getEvents; // Retrieve events from Vuex store
        },
    },
    props: ['userId'],
    mounted() {
        // Fetch events when the component is mounted
        this.$store.dispatch('fetchUserEvents', this.$route.params.userId);
    },
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
</style>