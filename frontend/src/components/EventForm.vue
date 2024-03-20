<template>
    <v-form @submit.prevent="submitForm">
      <v-container>
        <v-row>
          <v-col cols="12">
            <v-file-input v-model="featuredImage" label="Featured Image"></v-file-input>
          </v-col>
          <v-col cols="12">
            <v-text-field v-model="title" label="Event Title"></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="city" label="City"></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="category" label="Category"></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-textarea v-model="shortDescription" label="Short Description"></v-textarea>
          </v-col>
          <v-col cols="12">
            <v-textarea v-model="LongDescription" label="Long Description"></v-textarea>
          </v-col>
        </v-row>
  
        <v-btn type="submit" color="primary">Submit</v-btn>
      </v-container>
    </v-form>
  </template>
  
  <script>
  export default {
    data() {
      return {
        featuredImage: null,
        title: '',
        city: '',
        category: '',
        shortDescription: '',
        longDescription: '',
      };
    },
    methods: {
      submitForm() {
        // Handle form submission (create or edit event)
        // You can emit an event here to notify the parent component or handle form submission as needed
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add your custom styles here */
  </style>
  