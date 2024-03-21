<template>
    <v-form @submit.prevent="submitForm">
      <v-container class="form-container">
        <v-row>
          <v-col cols="12">
            <v-text-field v-model="localFormData.title" label="Event Title"></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-autocomplete
              v-model="localFormData.city"
              :items="citySuggestions"
              label="City"
              :loading="loadingCities"
              @input="handleCityInput"
            ></v-autocomplete>
          </v-col>
          <v-col cols="12">
          <v-subheader>Categories</v-subheader>
          <v-row>
            <v-col v-for="category in categoryOptions" :key="category.id" cols="4" class="pa-0">
              <v-checkbox
                v-model="localFormData.categoryIds"
                :label="category.name"
                :value="category.id"
                color="primary"
                dense
                class="d-inline-flex"
              ></v-checkbox>
            </v-col>
          </v-row>
        </v-col>
          <v-col cols="12">
            <v-textarea v-model="localFormData.shortDescription" label="Short Description"></v-textarea>
          </v-col>
          <v-col cols="12">
            <v-textarea v-model="localFormData.longDescription" label="Long Description"></v-textarea>
          </v-col>
          <v-col cols="12">
            <!-- Using Vuetify's flex utility classes to position the button -->
            <v-row align="center">
              <v-col cols="12" class="d-flex justify-end">
                <v-btn type="submit" color="primary">Submit</v-btn>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-container>
    </v-form>
  </template>
  
  <script>
  import { mapActions, mapState } from 'vuex';
  export default {
    data() {
      return {
        localFormData: {
          title: '',
          city: '',
          categoryIds: [],
          shortDescription: '',
          longDescription: '',
        },
      };
    },
    computed: {
      ...mapState(['citySuggestions', 'loadingCities', 'categoryOptions']), // Include loadingCities in computed properties
      formData() {
        return this.$store.state.formData;
      },
    },
    methods: {
      ...mapActions(['fetchCities', 'fetchCategoryOptions', 'submitForm']),
      async submitForm() {
        try {
          // Retrieve userID from Vuex state or wherever it's stored
          const userId = this.$store.state.userId;                
          // Include userID in the form data
          this.localFormData.userId = userId;
          // Dispatch action to submit form data
          await this.$store.dispatch('submitForm', this.localFormData);
        } catch (error) {
          console.error('Error submitting form:', error);
          // Handle error
        }
      },
      handleCityInput(event) {
        const value = event.target.value;
    this.fetchCities(value);
  },
    },
    created() {
        this.$store.dispatch('fetchCategoryOptions');
    }
  };
  </script>
  
  <style scoped>
  /* Add your custom styles here */
  .form-container {
    background-color: #fff;
    padding: 12px;
    border-radius: 4px;
  }
  </style>
  