<template>
    <div class="row">
        <div class="dashboard-layout col-2">
            <Sidebar />
            <div class="main-content">
                <router-view />
            </div>
        </div>
        <div class="container col-10 p-5">
            <h1>Expense Categories</h1>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Display Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created at</th>
                    </tr>
                </thead>
                <tbody v-if="expenseCategoryList.length > 0">
                    <tr v-for="(category, key) in expenseCategoryList" :key="key">
                        <td @click="openEditModal(category)">{{ category.expenseCategory }}</td>
                        <td @click="openEditModal(category)">{{ category.description }}</td>
                        <td @click="openEditModal(category)">{{ category.created_at }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Category
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="create">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" v-model="expense_categories.expenseCategory"/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" v-model="expense_categories.description"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Add Category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Expense Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="editCategory(expense_categories.id)">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="mb-3">
                                            <label for="categoryName" class="form-label">Category Name</label>
                                            <input v-model="expense_categories.expenseCategory" type="text"
                                                class="form-control" id="categoryName"
                                                placeholder="Enter role name" required
                                            />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <input v-model="expense_categories.description" type="text"
                                                class="form-control" id="description" placeholder="Enter description" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">
                                        Edit Category
                                    </button>
                                    <button class="btn btn-danger" @click="deleteRole(expense_categories.id)">
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
    name: "expenseCategory",
    components: { Sidebar },
    data() {
        return {
            expenseCategoryList: [],
            expense_categories: { expenseCategory: "", description: "" }, 
        };
    },
    mounted() {
        this.getExpenseCategory();
    },
    methods: {
        async getExpenseCategory() {
            await this.axios
                .get("http://127.0.0.1:8000/api/expenseCategory/")
                .then((response) => {
                    this.expenseCategoryList = response.data;
                })
                .catch((error) => {
                    console.log(error);
                    this.expenseCategoryList = [];
                });
        },
        openEditModal(category) {
            this.expense_categories = { ...category }; 
            const modal = new bootstrap.Modal(document.getElementById("editCategoryModal"));
            modal.show();
        },
        async editCategory(id) {
            await this.axios
                .patch(`http://127.0.0.1:8000/api/expenseCategory/${id}`, this.expense_categories)
                .then((response) => {
                    this.getExpenseCategory();
                    const modal = bootstrap.Modal.getInstance(document.getElementById("editCategoryModal"));
                    modal.hide(); 
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async deleteRole(id) {
            await this.axios
                .delete(`http://127.0.0.1:8000/api/expenseCategory/${id}`)
                .then((response) => {
                    this.getExpenseCategory();
                    modal.hide();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async create() {
            await this.axios.post("http://127.0.0.1:8000/api/expenseCategory/", this.expense_categories)
                .then(response => {
                    this.expense_categories = { expenseCategory: "", description: "" };
                    this.getExpenseCategory();
                    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.hide();
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
};
</script>
