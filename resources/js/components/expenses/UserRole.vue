<template>
    <div class="row container-fluid">
        <div class="dashboard-layout col-1 col-lg-2">
            <Sidebar />
            <div class="main-content">
                <router-view />
            </div>
        </div>
        <div class="container col-11 p-5 col-lg-10">
            <h1>User Role</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Display Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Created at</th>
                        </tr>
                    </thead>
                    <tbody v-if="userRoleList.length > 0">
                        <tr v-for="(role, key) in userRoleList" :key="key">
                            <td @click="openEditModal(role)">{{ role.roleName }}</td>
                            <td @click="openEditModal(role)">{{ role.description }}</td>
                            <td @click="openEditModal(role)">{{ role.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Button trigger for adding user role -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                Add Role
            </button>

            <!-- Modal for adding user role -->
            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRoleModalLabel">
                                Add User Role
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="create">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" v-model="userRole.roleName"/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" v-model="userRole.description"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Add Role
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for editing user role -->
            <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoleModalLabel">
                                Edit User Role
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="editRole(userRole.id)">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="mb-3">
                                            <label for="roleName" class="form-label">Role Name</label>
                                            <input v-model="userRole.roleName" type="text" class="form-control" id="roleName" placeholder="Enter role name">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <input v-model="userRole.description" type="text" class="form-control" id="description" placeholder="Enter description">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" @click="deleteRole(userRole.id)" data-bs-dismiss="modal">
                                        Delete
                                    </button>
                                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                                        Save Changes
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
    name: "userRole",
    components: { Sidebar },
    data() {
        return {
            userRoleList: [],
            userRole: { roleName: "", description: "" }, 
        };
    },
    mounted() {
        this.getUserRole();
    },
    methods: {
        async getUserRole() {
            await this.axios
                .get("http://127.0.0.1:8000/api/userRole/")
                .then((response) => {
                    this.userRoleList = response.data;
                })
                .catch((error) => {
                    console.log(error);
                    this.userRoleList = [];
                });
        },
        openEditModal(role) {
            this.userRole = { ...role }; 
            const modal = new bootstrap.Modal(document.getElementById("editRoleModal"));
            modal.show();
        },
        async editRole(id) {
            await this.axios.patch(`http://127.0.0.1:8000/api/userRole/${id}`, this.userRole)
                .then(response => {
                    this.getUserRole(); 
                    const modal = bootstrap.Modal.getInstance(document.getElementById("editRoleModal"));
                    modal.hide(); 
                })
                .catch(error => {
                    console.error(error);
                });
        },
        async deleteRole(id) {
            await this.axios
                .delete(`http://127.0.0.1:8000/api/userRole/${id}`)
                .then((response) => {
                    this.getUserRole();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async create() {
            await this.axios
                .post("http://127.0.0.1:8000/api/userRole/", this.userRole)
                .then((response) => {
                    this.userRole = { roleName: "", description: "" };
                    this.getUserRole(); 
                    const modal = bootstrap.Modal.getInstance(document.getElementById("addRoleModal"));
                    modal.hide(); 
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
