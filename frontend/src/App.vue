<template>
  <v-app class="pa-4">
    <AppHeader :isLoggedIn="isLoggedIn" @userLoggedIn="updateIsLoggedIn" />

    <v-main>
      <router-view :isLoggedIn="isLoggedIn"></router-view>
    </v-main>
    <AppFooter />
  </v-app>
</template>

<script>
import AppHeader from '@/components/AppHeader.vue';
import AppFooter from '@/components/AppFooter.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter
  },
  data() {
    return {
      isLoggedIn: false // Placeholder for user authentication status
    };
  },
  methods: {
    updateIsLoggedIn(value) {
      console.log('User logged in status:', value);
      this.isLoggedIn = value;
    },
  }
};
</script>

