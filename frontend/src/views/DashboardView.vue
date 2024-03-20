<template>
  <div class="dashboard">
    <h1>Welcome to the Dashboard!</h1>
    <!-- Include the EventForm component -->
    <EventForm></EventForm>
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
  }
};
</script>