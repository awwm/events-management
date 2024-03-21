# Events Management App

## Overview

Build a basic event management app to track event venues in Malta. Before registering venues, the app will be used to populate and manage the list of cities and venue categories.

### Back-end requirements:
- **PHP** without any framework
- **PostgreSQL** for persistent storage
- **Redis** for caching purposes

### Front-end requirements:
- **Vue.js**
- **Vuex** for state management
- **Vuetify** for the overall UI layout and styling

## Description

The Events Management App is designed to facilitate the tracking of event venues in Malta. It allows users to manage cities, venue categories, and events seamlessly.

- **Cities and Categories Management:**
  - Users can list, add, edit, and delete cities and categories.
  - Categories support multi-level infinite sub-categories for better organization.

- **Event Management:**
  - Events must be assigned to a specific city.
  - City autocomplete search functionality powered by a third-party API integration for seamless user experience.

- **Categorization:**
  - Events can be classified with multiple categories, allowing for better filtering and organization.

- **API-Driven Actions:**
  - Every action within the app is driven by a custom API, ensuring data integrity and consistency.

## Backend Stack
- **PHP**: The backend logic is implemented using PHP without relying on any framework, providing flexibility and customization options.
- **Database**: PostgreSQL is used for persistent storage, providing reliability and scalability.
- **Redis**: Utilize Redis for caching purposes to optimize performance and enhance scalability.

## Frontend Stack
- **Vue.js**: Implement the interactive user interface and dynamic components using Vue.js, a progressive JavaScript framework.
- **Vuex**: Manage application state efficiently using Vuex, ensuring consistency and predictability across components.
- **Vuetify**: Utilize Vuetify, a Material Design component library for Vue.js, to design and style the UI components consistently.

## Getting Started

1. **Clone the Repository:**
    - git clone https://github.com/awwm/events-management.git

2. **Backend Setup:**
- Set up a PHP environment and configure PostgreSQL.
- Install Redis and configure caching settings as needed.

3. **Frontend Setup:**
- Install Node.js and npm if not already installed.
- Navigate to the frontend directory and install dependencies:
  ```
  cd events-management/frontend
  npm install
  ```

4. **Configuration:**
- Access pgAdmin at [http://localhost:5050/browser/](http://localhost:5050/browser/) to register the server, host, and database.
- Set up environment variables for the backend.
- Uncomment lines inside backend/index.php (line number 29 till 43).

5. **Run the App:**
- Run the application using Docker:
  ```
  docker-compose up -d
  ```

6. **Access the Application:**
- Backend will be accessible at: [http://localhost:8081/](http://localhost:8081/)
- Frontend will be accessible at: [http://localhost:8080/](http://localhost:8080/)


7. **Initializing Database:**
- First view of homepage will initialise database.

## Note
- Make sure Docker is installed on your system before running the commands.
- Ensure proper configuration of environment variables and uncommenting of lines inside `backend/index.php` for successful backend setup.