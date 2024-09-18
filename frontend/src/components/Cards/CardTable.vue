<template>
  <div
    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
    :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']"
  >
    <div class="flex justify-between items-center mb-4 px-4 mt-4">
      <h2 class="text-2xl font-bold">List of Users</h2>
      <router-link
        to="/user-create"
        style="background-color: #006ca0"
        class="text-white px-4 py-3 rounded hover:bg-emerald-700 flex items-center"
      >
        <i class="fas fa-plus mr-2"></i>
        Add Client
      </router-link>
    </div>
    <div class="block w-full overflow-x-auto">
      <!-- Projects table -->
      <table class="items-center w-full bg-transparent border-collapse">
        <thead>
          <tr>
            <th
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              ID
            </th>
            <th
              class="px-6 align-middle py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500'
                  : 'bg-emerald-800 text-emerald-300',
                'custom-border',
              ]"
            >
              Profile
            </th>
            <th
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Full Name
            </th>
            <th
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Age
            </th>
            <th
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Phone Number
            </th>
            <th
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(client, index) in clients" :key="client.id">
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 whitespace-nowrap p-4"
            >
              {{ index + 1 }}
              <!-- Show index + 1 for client ID -->
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 whitespace-nowrap p-4"
            >
              <img
                v-if="client.profile"
                :src="`http://127.0.0.1:8000/storage/${client.profile}`"
                class="h-12 w-12 bg-white rounded-full border"
                alt="Profile"
              />
              <img
                v-else
                src="../../assets/img/def-logo.png"
                class="h-12 w-12 bg-white rounded-full border"
                alt="Default Profile"
              />
            </td>
            <td
              class="border-t-0 px-6 text-sm align-middle border-l-0 border-r-0 whitespace-nowrap p-4"
            >
              {{ client.name }}
              <!-- Use client.name instead of user.name -->
            </td>
            <td
              class="border-t-0 px-6 text-sm align-middle border-l-0 border-r-0 whitespace-nowrap p-4"
            >
              {{ client.age }}
              <!-- Use client.age instead of client.age -->
            </td>
            <td
              class="border-t-0 px-6 text-sm align-middle border-l-0 border-r-0 whitespace-nowrap p-4"
            >
              {{ client.phone_number }}
              <!-- Use client.phone_number instead of client.phone_numberl -->
            </td>

            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 whitespace-nowrap p-4"
            >
              <router-link
                :to="{ path: '/client-edit', query: { id: client.id } }"
              >
                <i style="color: orange" class="fas fa-edit text-lg mr-3"></i>
              </router-link>
              <i
                @click="deleteClient(client.id)"
                style="color: red"
                class="fas fa-trash text-lg"
              ></i>
              <!-- Use deleteClient -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { computed } from "vue";
import { useAuthStore } from "@/stores/auth-store";

export default {
  data() {
    return {
      clients: [],
    };
  },

  props: {
    color: {
      default: "light",
      validator: function (value) {
        return ["light", "dark"].includes(value);
      },
    },
  },

  setup() {
    const authStore = useAuthStore();
    const clientId = computed(() => authStore.user?.id);

    return {
      clientId,
    };
  },

  mounted() {
    this.fetchClients();
  },

  methods: {
    async fetchClients() {
      try {
        const response = await axios.get(
          "http://127.0.0.1:8000/api/clients/list"
        ); // Ensure this endpoint is correct
        this.clients = response.data.data; // Ensure this matches your API response structure
      } catch (error) {
        console.error("Error fetching clients:", error);
      }
    },

    async deleteClient(id) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/client/delete/${id}`);
        this.fetchClients(); // Refresh the client list after deletion
      } catch (error) {
        console.error("Error deleting client:", error);
      }
    },
  },

  computed: {
    headerClass() {
      return this.color === "light"
        ? "bg-blueGray-50 text-blueGray-500 border-blueGray-100"
        : "bg-emerald-800 text-emerald-300 border-emerald-700";
    },
  },
};
</script>
