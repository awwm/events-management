import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/RegisterView.vue'
import SigninView from '../views/SigninView.vue'
import DashboardView from '../views/DashboardView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/register', // Route for the register page
    name: 'register',
    component: RegisterView
  },
  {
    path: '/signin', // Route for the signin page
    name: 'signin',
    component: SigninView
  },
  {
    path: '/dashboard/:userId',
    name: 'dashboard',
    component: DashboardView,
    meta: { requiresAuth: true } // Add this meta field to require authentication
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('token');
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next('/signin'); // Redirect to signin page if not authenticated
    } else {
      next(); // Proceed to the route if authenticated
    }
  } else {
    next(); // Allow access to routes that don't require authentication
  }
});

export default router
