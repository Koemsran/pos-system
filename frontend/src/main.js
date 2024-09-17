import { createApp } from "vue";
import { createWebHistory, createRouter } from "vue-router";
import { createPinia } from 'pinia'; 
// styles

import "@fortawesome/fontawesome-free/css/all.min.css";
import "@/assets/styles/tailwind.css";

// mouting point for the whole app

import App from "@/App.vue";

// layouts

import Admin from "@/layouts/Admin.vue";

// views for Admin layout

import Dashboard from "@/views/admin/Dashboard.vue";
import Settings from "@/views/admin/Settings.vue";
import Tables from "@/views/admin/Tables.vue";
import Maps from "@/views/admin/Maps.vue";

// views for Auth layout

import Login from "@/views/auth/Login.vue";
import Register from "@/views/auth/Register.vue";

// views without layouts

import Profile from "@/views/Profile.vue";
// import Index from "@/views/Index.vue";

// routes

const routes = [
  {
    path: "/admin",
    redirect: "/admin/dashboard",
    component: Admin,
    children: [
      {
        path: "/admin/dashboard",
        component: Dashboard,
      },
      {
        path: "/admin/settings",
        component: Settings,
      },
      {
        path: "/admin/tables",
        component: Tables,
      },
      {
        path: "/admin/maps",
        component: Maps,
      },
      {
        path: "/",
        component: Dashboard,
      },
    ],
  },
  {
    path: "/auth/login",
    component: Login,
  },
  {
    path: "/auth/register",
    component: Register,
  },
  {
    path: "/profile",
    component: Profile,
  },
 
  { path: "/:pathMatch(.*)*", redirect: "/" },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});
router.beforeEach((to, from, next) => {
  const publicRoutes = ['/auth/login', '/auth/register'];
  const isAuthenticated = localStorage.getItem('isAuthenticated') === 'true';

  if (publicRoutes.includes(to.path)) {
    next(); // Allow navigation to public routes
  } else if (isAuthenticated) {
    next(); // Allow navigation if authenticated
  } else {
    next('/auth/login'); // Redirect to login if not authenticated
  }
});
const pinia = createPinia();
createApp(App).use(router).use(pinia).mount("#app");
