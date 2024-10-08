<template>
    <div>
        <sidebar />
        <div class="relative md:ml-64 bg-blueGray-100 right">
            <admin-navbar class="bg-green-600 shadow-md" />
            <div class="px-4 md:px-10 mx-auto w-full app">

                <div class="container mx-auto bg-white shadow-md" style="width: 60%; padding: 30px;">
                    <h2 class="text-2xl font-bold mb-6">Edit User</h2>

                    <form @submit.prevent="submitForm">

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input v-model="form.name" type="text" id="name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </div>

                        <!-- Profile Field (Optional) -->
                        <div class="mb-4">
                            <label for="profile" class="block text-sm font-medium text-gray-700">Profile
                                (Optional)</label>
                            <input type="file" @change="handleFileUpload" id="profile"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input v-model="form.email" type="email" id="email"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </div>

                        <!-- Role Select -->
                        <div class="mb-4">
                            <label for="roles" class="block text-sm font-medium text-gray-700">Roles</label>
                            <select v-model="form.roles" id="roles" multiple
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                            </select>
                        </div>
                       
                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" style="background-color: #006ca0;" class="text-white px-4 py-2 rounded-md mr-3">Update
                                User</button>
                            <button type="button" @click="cancel"
                                class="bg-red-500 text-white px-4 py-2 rounded-md">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AdminNavbar from "@/components/Navbars/AdminNavbar.vue";
import Sidebar from "@/components/Sidebar/Sidebar.vue";
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';

export default {
    components: {
        AdminNavbar,
        Sidebar,
    },
    setup() {
        const route = useRoute(); // Get the route instance
        const router = useRouter(); // Get the router instance
        return { router, route };
    },
    data() {
        return {
            form: {
                name: '',
                profile: null,
                email: '',
                password: '',
                roles: [], // Changed to an array
                leave_balance: null,
                department: ''
            },
            roles: [],
            userId: null
        };
    },
    mounted() {
        this.fetchRoles();
        this.userId = this.$route.query.id
        this.showUser(this.userId);
    },
    methods: {
        handleFileUpload(event) {
            this.form.profile = event.target.files[0];
        },
        async submitForm() {
            let formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('email', this.form.email);

            // Append roles as individual entries
            this.form.roles.forEach(role => {
                formData.append('roles[]', role);
            });

            // Append the profile only if a file is selected
            if (this.form.profile) {
                formData.append('profile', this.form.profile);
            }
            // for (let pair of formData.entries()) {
            //     console.log(pair[0] + ': ' + pair[1]); // Logs each key-value pair in the FormData
            // }
            try {
                // Use the correct axios method, `put` or `patch` instead of `update`
                await axios.post(`http://127.0.0.1:8000/api/user/update/${this.userId}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                this.resetForm();
                this.router.push('/user');
            } catch (error) {
                alert('Error updating user');
                console.error(error);
            }
        },
        async showUser(id) {
            if (this.userId) {
                try {
                    const response = await axios.get(`http://127.0.0.1:8000/api/user/show/${id}`);
                    const userData = response.data.data;

                    // Populate form with user data
                    this.form.name = userData.name;
                    this.form.email = userData.email;
                    this.form.roles = userData.roles.map(role => role.id); // assuming roles are an array of objects

                    // Set profile (URL or file path) if it exists
                    if (userData.profile) {
                        this.form.profile = userData.profile; // Assuming profile is a URL or file path
                    }

                } catch (error) {
                    console.error('Error fetching user:', error);
                }
            }
        },
        async fetchRoles() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/roles/list');
                this.roles = response.data.data;
            } catch (error) {
                console.error('Error fetching roles:', error);
            }
        },
        resetForm() {
            this.form = {
                name: '',
                profile: null,
                email: '',
                password: '',
                roles: [],
            };
        },
        cancel() {
            this.router.push('/user'); // Redirect to user list on cancel
        }
    }
};
</script>

<style>
.right {
    display: flex;
    flex-direction: column;
    gap: 50px;
}

.app {
    margin-top: 90px;
}
</style>