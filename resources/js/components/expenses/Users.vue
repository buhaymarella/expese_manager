<template>
    <div class="row">
        <div class="dashboard-layout col-2">
            <Sidebar />
            <div class="main-content">
                <router-view />
            </div>
        </div>
        <div class="container col-10 p-5">
            <h1>Users</h1>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created at</th>
                    </tr>
                </thead>
                <tbody v-if="usersList.length > 0">
                    <tr v-for="(user, key) in usersList" :key="key">
                        <td @click="openEditUserModal(user)">{{ user.name }}</td>
                        <td @click="openEditUserModal(user)">{{ user.email }}</td>
                        <td @click="openEditUserModal(user)">{{ user.role.roleName }}</td>
                        <td @click="openEditUserModal(user)">{{ user.created_at }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add User
            </button>

            <!--Add User Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Add User
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="create">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" v-model="users.name" required />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" v-model="users.email" required/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" v-model="users.password" required />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-select" v-model="users.role_id" required >
                                                <option value="" disabled>
                                                    Select Role
                                                </option>
                                                <option class="text-dark" v-for="role in roles" :key="role.id" :value="role.id">
                                                    {{ role.roleName }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Add User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Update/Delete User Modal-->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Update User
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="editUser(users.id)">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label for="user_name">Name</label>
                                            <input id="user_name" type="text" class="form-control" v-model="users.name" required placeholder="Enter name" />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label for="user_email">Email</label>
                                            <input id="user_email" type="email" class="form-control" v-model="users.email" required placeholder="Enter email"/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label for="user_role">Role</label>
                                            <select class="form-select" v-model="users.role_id" required id="user_role">
                                                <option value="" disabled>
                                                    Select Role
                                                </option>
                                                <option class="text-dark" v-for="role in roles" :key="role.id" :value="role.id">
                                                    {{ role.roleName }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <button class="btn btn-danger" @click="deleteUser(users.id)">
                                        Delete
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from "../SideBar.vue";

export default {
    name: "users",
    components: { Sidebar },
    data() {
        return {
            usersList: [],
            users: { name: "", email: "", role_id: null, password: "" },
            roles: [], 
        };
    },
    mounted() {
        this.getUsers();
        this.getRoles(); 
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
                this.roles = response.data; 
            } catch (error) {
                console.log(error);
            }
        },
        openEditUserModal(user){
            this.users = {...user};
            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        },
        async editUser(id) {
            try {
                await this.axios.patch(`http://127.0.0.1:8000/api/users/${id}`, this.users);
                this.getUsers(); 
                const modal = bootstrap.Modal.getInstance(document.getElementById("editUserModal"));
                modal.hide(); 
                this.users = { name: "", email: "", role_id: null, password: "" };
            } catch (error) {
                console.log(error);
            }
        },
        async deleteUser(id) {
            await this.axios
                .delete(`http://127.0.0.1:8000/api/users/${id}`)
                .then((response) => {
                    this.getUsers();
                    modal.hide();
                })
            .catch((error) => {
                console.log(error);
            });
        },
        async create() {
            try {
                const response = await this.axios.post(
                    "http://127.0.0.1:8000/api/users/",
                    this.users
                );
                console.log(response.data); 
                this.users = {
                    name: "",
                    email: "",
                    role_id: null,
                    password: "",
                };
                this.getUsers();
                const modal = new bootstrap.Modal(
                    document.getElementById("exampleModal")
                );
                modal.hide();
            } catch (error) {
                console.log(error.response.data); 
            }
        },
    },
};
</script>
