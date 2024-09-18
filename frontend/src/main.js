import { createApp } from "vue";
import { createWebHistory, createRouter } from "vue-router";
import { createPinia } from 'pinia'; 
import piniaPersist from 'pinia-plugin-persistedstate';
import { useAuthStore } from '@/stores/auth-store';


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
import UserList from "@/views/user/UserList.vue";
import CreateUser from "@/views/user/CreateUser.vue";
import EditUser from "@/views/user/EditUser.vue";
import Roles from "@/views/user/Role.vue";


// view schedule 
import Schedule from "@/views/schedule/Schedule.vue";


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
        path: "/admin/client-progress",
        component: Maps,
      },
      {
        path: "/schedule",
        component: Schedule,
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
    path: "/user",
    component: UserList,
  },
  {
    path: "/user-create",
    component: CreateUser,
  },
  {
    path: "/user-edit",
    component: EditUser,
  },
  {
    path: "/role",
    component: Roles,
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
  const authStore = useAuthStore();
  const isAuthenticated = authStore.isAuthenticated;

  if (publicRoutes.includes(to.path)) {
    next(); // Allow navigation to public routes
  } else if (isAuthenticated) {
    next(); // Allow navigation if authenticated
  } else {
    next('/auth/login'); // Redirect to login if not authenticated
  }
});
const pinia = createPinia();
pinia.use(piniaPersist);
createApp(App).use(router).use(pinia).mount("#app");
