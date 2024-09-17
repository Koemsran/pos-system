<template>
  <div>
    <a
      class="text-blueGray-500 block"
      href="#pablo"
      ref="btnDropdownRef"
      v-on:click="toggleDropdown($event)"
    >
      <div class="items-center flex">
        <span
          class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"
        >
          <img
            alt="..."
            class="w-full rounded-full align-middle border-none shadow-lg"
            :src="image"
          />
        </span>
      </div>
    </a>
    <div ref="popoverDropdownRef"
      class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48"
      :class="{ hidden: !dropdownPopoverShow, block: dropdownPopoverShow }">
      <a href="/profile"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">
        <i class="fas fa-user mr-2"></i> My Account
      </a>
      <a @click="userLogout"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700 cursor-pointer">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
      </a>
      <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
      <a href="/admin/settings"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">
        <i class="fas fa-cog mr-2"></i> Account Setting
      </a>
    </div>
  </div>
</template>

<style scoped>
@import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css';

.profile-container {
  width: 50px;
  height: 50px;
  background-color: #e2e8f0;
  border: 2px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  overflow: hidden;
}

.profile-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>

<script>
import { createPopper } from "@popperjs/core";
import { ref, onMounted } from "vue";
import { useAuthStore } from '@/stores/auth-store'; // Adjust the path if necessary

export default {
  setup() {
    const authStore = useAuthStore(); // Access the auth store
    const user = ref({});
    const dropdownPopoverShow = ref(false);

    const btnDropdownRef = ref(null);
    const popoverDropdownRef = ref(null);

    onMounted(async () => {
      try {
        await authStore.fetchUser(); // Fetch user data from the store
        user.value = authStore.user;
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    });

    function toggleDropdown(event) {
      event.preventDefault();
      dropdownPopoverShow.value = !dropdownPopoverShow.value;
      if (dropdownPopoverShow.value && btnDropdownRef.value && popoverDropdownRef.value) {
        createPopper(btnDropdownRef.value, popoverDropdownRef.value, {
          placement: "bottom-start",
        });
      }
    }

    async function userLogout() {
      try {
        await authStore.logout(); // Use store action to logout

        // Redirect to login page
        window.location.href = '/auth/login'; // Adjust route as necessary
      } catch (error) {
        console.error('Error logging out:', error);
      }
    }

    return {
      user,
      dropdownPopoverShow,
      toggleDropdown,
      userLogout,
      btnDropdownRef,
      popoverDropdownRef,
    };
  }
};
</script>