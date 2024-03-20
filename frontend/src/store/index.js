import { createStore } from 'vuex';
import { BASE_URL } from '../../constants'; // Import the BASE_URL constant

export default createStore({
  state: {
    events: [],
    isLoggedIn: false,
    isAuthenticated: false,
    formData: {
      title: '',
      city: '',
      category: '',
      shortDescription: '',
      longDescription: '',
    },
  },
  mutations: {
    SET_AUTHENTICATED(state, isAuthenticated) {
      state.isAuthenticated = isAuthenticated;
    },
    setEvents(state, events) {
      state.events = events;
    },
    setFormData(state, payload) {
      state.formData = { ...payload };
    },
    resetFormData(state) {
      state.formData = {
        title: '',
        city: '',
        category: '',
        shortDescription: '',
        longDescription: '',
      };
    },
  },

  actions: {
    async registerUser(_, regData) {
      try {
        const response = await fetch(BASE_URL + 'api/UserAPI/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            username: regData.username,
            email: regData.email,
            password: regData.password,
            register: regData.register
          }),
        });
        return response;
      } catch (error) {
        console.error('Registration error:', error);
        return false;
      }
    },
    async signinUser(_, userData) {
      try {
        const response = await fetch(BASE_URL + 'api/UserAPI/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            email: userData.email,
            password: userData.password
          })
        });
        return response;
      } catch (error) {
        console.error('Login error:', error);
        return false;
      }
    },
    async fetchUserEvents({ commit }, userId) {
      try {
        const response = await fetch(`${BASE_URL}api/EventAPI/?userId=${userId}`, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        // Handle response and update Vuex state
        if (response.ok) {
          const events = await response.json();
          // Update events state
          commit('setEvents', events);
        } else {
          console.error('Failed to fetch events:', response.statusText);
        }
      } catch (error) {
        console.error('Error fetching user events:', error);
      }
    },
    async submitForm({ commit }, formData) {
      try {
        // Post form data to backend API
        let response = await fetch(BASE_URL + 'api/EventAPI', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(formData),
        });
    
        if (!response.ok) {
          throw new Error('Failed to post form data');
        }
    
        // Handle successful form submission
        console.log('Form submitted successfully');
        // Reset form data
        commit('resetFormData');
      } catch (error) {
        console.error('Error submitting form:', error);
        throw error; // Re-throw the error for further handling if needed
      }
    },
    setAuthenticated({ commit }, isAuthenticated) {
      commit('SET_AUTHENTICATED', isAuthenticated);
    },
    logoutUser({ commit }) {
      commit('SET_AUTHENTICATED', false);
      // Additional logout logic if needed (e.g., clear local storage)
      localStorage.removeItem('token'); // Remove JWT token from local storage
    },
  },

  getters: {
    // Getter to retrieve events
    getEvents(state) {
      return state.events;
    },
    // Getter to check authentication status
    isAuthenticated(state) {
      return state.isAuthenticated;
    },
    // Other getters as needed
  },
});
