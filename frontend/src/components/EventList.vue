<template>
    <div>
        <h2>Event List</h2>
        <div v-if="events.length > 0">
            <div v-for="event in events" :key="event.id">
                <!-- Display event details here -->
                <p>{{ event.name }}</p>
                <!-- Add more details as needed -->
            </div>
        </div>
        <div v-else>
            <p>No events available</p>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    props: {
        userId: {
            type: Number, // userId is a number
            default: null, // Default value to handle the case where userId is not provided
        },
        publicPage: {
            type: Boolean,
            default: true, // Public page by default
        },
    },
    computed: {
        ...mapGetters(['getEvents']),
        events() {
            return this.getEvents; // Retrieve events from Vuex store
        },
    },
    mounted() {
        // Fetch events when the component is mounted
        if (this.publicPage) {
            this.$store.dispatch('fetchEvents');
        } else if (this.userId !== null) {
            this.$store.dispatch('fetchUserEvents', this.userId);
        }
    },
};
</script>

<style scoped>
/* Add custom CSS styles here if needed */
</style>