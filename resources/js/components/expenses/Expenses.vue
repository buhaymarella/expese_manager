<template>
    <div class="row">
        <div class="dashboard-layout col-2">
            <Sidebar />
            <div class="main-content">
                <router-view />
            </div>
        </div>
        <div class="container col-10 p-5">
            
            <h1>Expenses</h1>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Expense Category</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Entry Date</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Owner</th>
                    </tr>
                </thead>
                <tbody v-if="expensesList.length > 0">
                    <tr v-for="(expense, key) in expensesList" :key="key">
                        <td @click="openEditExpensesModal(expense)">{{ expense.category.expenseCategory }}</td>
                        <td @click="openEditExpensesModal(expense)">{{ expense.amount }}</td>
                        <td @click="openEditExpensesModal(expense)">{{ expense.entry_date }}</td>
                        <td @click="openEditExpensesModal(expense)">{{ expense.created_at }}</td>
                        <td @click="openEditExpensesModal(expense)">{{ expense.user.name }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Expense
            </button>

            <!--Add Expense Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Add Expense
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="create">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-select" v-model="expenses.category_id" required >
                                                <option value="" disabled>
                                                    Select Category
                                                </option>
                                                <option class="text-dark" v-for="cat in category" :key="cat.id" :value="cat.id">
                                                    {{ cat.expenseCategory }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" v-model="expenses.amount" required/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Entry Date</label>
                                            <input type="date" class="form-control" v-model="expenses.entry_date" required />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>User</label>
                                            <select class="form-select" v-model="expenses.user_id" required >
                                                <option value="" disabled>
                                                    Select User
                                                </option>
                                                <option class="text-dark" v-for="user in users" :key="user.id" :value="user.id">
                                                    {{ user.name }}
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
                                        Add Expense
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Update/Delete Expense Modal-->
            <div class="modal fade" id="editExpensesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Update User
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="editExpenses(expenses.id)">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-select" v-model="expenses.category_id" required >
                                                <option value="" disabled>
                                                    Select Category
                                                </option>
                                                <option class="text-dark" v-for="cat in category" :key="cat.id" :value="cat.id">
                                                    {{ cat.expenseCategory }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" v-model="expenses.amount" required/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Entry Date</label>
                                            <input type="date" class="form-control" v-model="expenses.entry_date" required />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>User</label>
                                            <select class="form-select" v-model="expenses.user_id" required disabled>
                                                <option value="" disabled>
                                                    Select User
                                                </option>
                                                <option class="text-dark" v-for="user in users" :key="user.id" :value="user.id">
                                                    {{ user.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <button class="btn btn-danger" @click="deleteExpenses(expenses.id)">
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
    name: "expenses",
    components: { Sidebar },
    data() {
        return {
            expensesList: [],
            expenses: { amount: "", category_id: null, user_id: null, entry_date: "" },
            users: [],
            category: [], 
        };
    },
    mounted() {
        this.getExpenses();
        this.getUsers(); 
        this.getCategory(); 
    },
    methods: {
        async getExpenses() {
            await this.axios
                .get("http://127.0.0.1:8000/api/expenses/")
                .then((response) => {
                    this.expensesList = response.data;
                })
                .catch((error) => {
                    console.log(error);
                    this.expensesList = [];
                });
        },
        async getUsers() {
            try {
                const response = await this.axios.get(
                    "http://127.0.0.1:8000/api/users/"
                );
                this.users = response.data; 
            } catch (error) {
                console.log(error);
            }
        },
        async getCategory() {
            try {
                const response = await this.axios.get(
                    "http://127.0.0.1:8000/api/expenseCategory/"
                );
                this.category = response.data; 
            } catch (error) {
                console.log(error);
            }
        },
        openEditExpensesModal(expense) {
            this.expenses = { ...expense }; 
            const modal = new bootstrap.Modal(document.getElementById('editExpensesModal'));
            modal.show();
        },

        async editExpenses(id) {
            try {
                const response = await this.axios.patch(`http://127.0.0.1:8000/api/expenses/${id}`, this.expenses);
                console.log('Update Response:', response.data); 
                this.getExpenses();
                const modal = bootstrap.Modal.getInstance(document.getElementById("editExpensesModal"));
                modal.hide(); 
                // Resetting form
                this.expenses = { amount: "", category_id: null, entry_date: "", user_id: null };
            } catch (error) {
                console.log('Update Error:', error); 
            }
        },
        async deleteExpenses(id) {
            const confirmed = confirm("Are you sure you want to delete this expense?");
            if (!confirmed) return;

            try {
                await this.axios.delete(`http://127.0.0.1:8000/api/expenses/${id}`);
                this.getExpenses(); 
                const modal = bootstrap.Modal.getInstance(document.getElementById("editExpensesModal"));
                if (modal) {
                    modal.hide(); 
                }
            } catch (error) {
                console.log('Delete Error:', error); 
            }
        },
        async create() {
            try {
                const response = await this.axios.post("http://127.0.0.1:8000/api/expenses/", this.expenses);
                console.log(response.data); 
                const modal = new bootstrap.Modal(document.getElementById("exampleModal"));
                modal.hide();
            } catch (error) {
                console.log(error.response.data); 
            }
        },

    },
};
</script>
