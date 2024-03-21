import { createStore } from 'vuex';
import { BASE_URL } from '../../constants'; // Import the BASE_URL constant

export default createStore({
  state: {
    events: [],
    citySuggestions: [],
    categoryOptions: [],
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
    SET_USER_ID(state, userId) {
      state.userId = userId;
    },
    setCitySuggestions(state, cityNames) {
      state.citySuggestions = cityNames;
    },
    setCategoryOptions(state, categoryOptions) {
      state.categoryOptions = categoryOptions;
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
    // Iinitialize the database
    async initializeDatabase() {
      try {
        const response = await fetch(BASE_URL + 'api/init-database');
        if (response.ok) {
          const data = await response.json();
          console.log('Database initialization successful', data);
        } else {
          console.error('Failed to initialize database:', response.statusText);
        }
      } catch (error) {
        console.error('Error initializing database:', error);
      }
    },
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
    async fetchEvents({ commit }) {
      try {
        const response = await fetch(`${BASE_URL}api/EventAPI`, {
          method: 'GET',
        });
        if (response.ok) {
          const events = await response.json();
          commit('setEvents', events);
        } else {
          console.error('Failed to fetch events:', response.statusText);
        }
      } catch (error) {
        console.error('Error fetching events:', error);
      }
    },
    async fetchUserEvents({ commit }, userId) {
      try {
        if (!userId) {
          console.error('User ID is required to fetch user events');
          return;
        }
        const response = await fetch(`${BASE_URL}api/EventAPI/?userId=${userId}`, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        if (response.ok) {
          const events = await response.json();
          commit('setEvents', events);
        } else {
          console.error('Failed to fetch user events:', response.statusText);
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
    async fetchCities({ commit }, query) {
      const countryCode = 'MT';
      const username = 'ammpl';
      const typedQuery = typeof query === 'string' ? query.trim() : query;
      if (typedQuery.length < 2) return;
  
      try {
        const response = await fetch(`http://api.geonames.org/searchJSON?q=${encodeURIComponent(typedQuery)}&country=${encodeURIComponent(countryCode)}&featureClass=P&maxRows=10&username=${encodeURIComponent(username)}`);
        if (!response.ok) {
          throw new Error('Failed to fetch cities');
        }
        const data = await response.json();
        const cityNames = data.geonames.map(city => city.name);
        commit('setCitySuggestions', cityNames); // Update citySuggestions state in Vuex store
      } catch (error) {
        console.error('Error fetching cities:', error);
        // Handle error
      }
    },
    async fetchCategoryOptions({ commit }) {
      try {
        const response = await fetch(`${BASE_URL}api/CategoryAPI`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        });
        if (!response.ok) {
          throw new Error('Failed to fetch category options');
        }

        // Check if response body is empty
        const text = await response.text();
    
        const data = JSON.parse(text);
        console.log(data);
        if (!data || Object.keys(data).length === 0) {
          // Handle empty response (e.g., return an empty array)
          commit('setCategoryOptions', []);
        } else {
          // Update categoryOptions state in Vuex store
          const transformedData = data.map(category => ({
            id: category.id,
            name: category.name,
          }));
          commit('setCategoryOptions', transformedData);
        }
      } catch (error) {
        console.error('Error fetching category options:', error);
        // Handle error
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
    citySuggestions: state => state.citySuggestions,
  },
});
