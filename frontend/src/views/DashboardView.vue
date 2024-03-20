<template>
  <div class="dashboard">
    <!-- Other content in the dashboard view -->
    <EventList />
  </div>
</template>

<script>
import EventList from '@/components/EventList.vue';

export default {
  components: {
    EventList
  }
};
</script>