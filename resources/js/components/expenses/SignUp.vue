<template>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card text-start shadow p-3" style="width: 20rem;">
            <h2 class="h2">Sign up</h2>
            <form @submit.prevent="create">
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        v-model="users.name"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input
                        type="text"
                        name="email"
                        class="form-control"
                        v-model="users.email"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        v-model="users.password"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="role">Role</label>
                    <select
                        class="form-select"
                        v-model="users.role_id"
                        required
                    >
                        <option value="" disabled>Select Role</option>
                        <option
                            class="text-dark"
                            v-for="role in roles"
                            :key="role.id"
                            :value="role.id"
                        >
                            {{ role.roleName }}
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    Sign up
                </button>
                <hr />
                <router-link to="/">
                    <button class="btn btn-outline-primary w-100">Login</button>
                </router-link>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "users",
    data() {
        return {
            usersList: [],
            users: { name: "", email: "", role_id: null, password: "" },
            roles: [],
        };
    },
    mounted() {
        this.getUsers();
        this.getRoles(); // Fetch roles on mount
    },
    methods: {
        async getUsers() {
            await this.axios
                .get("http://127.0.0.1:8000/api/users/")
                .then((response) => {
                    this.usersList = response.data;
                })
                .catch((error) => {
                    console.log(error);
                    this.usersList = [];
                });
        },
        async getRoles() {
            try {
                const response = await this.axios.get(
                    "http://127.0.0.1:8000/api/userRole/"
                );
                this.roles = response.data; // Assume this endpoint returns roles
            } catch (error) {
                console.log(error);
            }
        },
        async deleteUser(id) {
            try {
                await this.axios.delete(
                    `http://127.0.0.1:8000/api/users/${id}`
                );
                this.getUsers();
            } catch (error) {
                console.log(error);
            }
        },
        async create() {
            try {
                const response = await this.axios.post(
                    "http://127.0.0.1:8000/api/users/",
                    this.users
                );
                console.log("User created successfully:", response.data);
                this.users = {
                    name: "",
                    email: "",
                    role_id: null,
                    password: "",
                };
                this.getUsers(); 
            } catch (error) {
                console.error(
                    "Error creating user:",
                    error.response ? error.response.data : error.message
                ); 
            }
        },
    },
};
</script>
