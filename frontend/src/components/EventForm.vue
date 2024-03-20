<template>
    <v-form @submit.prevent="submitForm">
        <v-container class="form-container">
            <v-row>
                <v-col cols="12">
                    <v-text-field v-model="localFormData.title" label="Event Title"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="localFormData.city" label="City"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="localFormData.category" label="Category"></v-text-field>
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
export default {
    data() {
        return {
            localFormData: {
                title: '',
                city: '',
                category: '',
                shortDescription: '',
                longDescription: '',
            },
        };
    },
    computed: {
        formData() {
            return this.$store.state.formData;
        },
    },
    watch: {
        formData: {
            handler(newValue) {
                // Sync Vuex state with local form data when Vuex state changes
                this.localFormData = { ...newValue };
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
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
    },
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
