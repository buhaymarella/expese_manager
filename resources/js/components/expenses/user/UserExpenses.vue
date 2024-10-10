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
                    </tr>
                </thead>
                <tbody v-if="filteredExpensesList.length > 0">
                    <tr v-for="(expense, key) in filteredExpensesList" :key="key">
                        <td @click="openEditExpensesModal(expense)">{{ expense.category.expenseCategory }}</td>
                        <td @click="openEditExpensesModal(expense)">$ {{ expense.amount }}</td>
                        <td @click="openEditExpensesModal(expense)">{{ expense.entry_date }}</td>
                        <td @click="openEditExpensesModal(expense)">{{ expense.created_at }}</td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="4" class="text-center">No expenses found.</td>
                    </tr>
                </tbody>
            </table>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Expense
            </button>

            <!-- Add Expense Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="create">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-select" v-model="expenses.category_id" required>
                                                <option value="" disabled>Select Category</option>
                                                <option class="text-dark" v-for="cat in category" :key="cat.id" :value="cat.id">
                                                    {{ cat.expenseCategory }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" v-model="expenses.amount" required />
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
                                            <select class="form-select" v-model="expenses.user_id" disabled>
                                                <option value="" disabled>Select User</option>
                                                <option class="text-dark" :value="loggedInUserId">
                                                    {{ loggedInUserName }} 
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Expense</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update/Delete Expense Modal -->
            <div class="modal fade" id="editExpensesModal" tabindex="-1" aria-labelledby="editExpensesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editExpensesModalLabel">Update Expense</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="editExpenses(expenses.id)">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-select" v-model="expenses.category_id" required>
                                                <option value="" disabled>Select Category</option>
                                                <option class="text-dark" v-for="cat in category" :key="cat.id" :value="cat.id">
                                                    {{ cat.expenseCategory }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" v-model="expenses.amount" required />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Entry Date</label>
                                            <input type="date" class="form-control" v-model="expenses.entry_date" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button class="btn btn-danger" @click="deleteExpenses(expenses.id)">Delete</button>
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
import Sidebar from "./UserSideBar.vue";

export default {
    name: "expenses",
    components: { Sidebar },
    data() {
        return {
            expensesList: [],
            expenses: { amount: "", category_id: null, user_id: null, entry_date: "" },
            users: [],
            category: [],
            loggedInUserId: null, 
            loggedInUserName: '', 
        };
    },
    mounted() {
        
        this.loggedInUserId = sessionStorage.getItem('loggedInUserId'); 
        this.loggedInUserName = sessionStorage.getItem('loggedInUserName') || 'User'; 
        console.log('Logged In User ID:', this.loggedInUserId); 
        this.getExpenses();
        this.getUsers(); 
        this.getCategory(); 
    },
    computed: {
        
        filteredExpensesList() {
            console.log(`Total Expenses Loaded: ${this.loggedInUserId}`); 
            return this.expensesList.filter(expense => expense.user_id === Number(this.loggedInUserId));
        },
    },
    methods: {
        async getExpenses() {
            await this.axios
                .get("http://127.0.0.1:8000/api/expenses/")
                .then((response) => {
                    console.log(response.data); 
                    this.expensesList = response.data;
                })
                .catch((error) => {
                    console.log(error);
                    this.expensesList = [];
                });
        },
        async getUsers() {
            try {
                const response = await this.axios.get("http://127.0.0.1:8000/api/users/");
                this.users = response.data; 
            } catch (error) {
                console.log(error);
            }
        },
        async getCategory() {
            try {
                const response = await this.axios.get("http://127.0.0.1:8000/api/expenseCategory/");
                this.category = response.data; 
            } catch (error) {
                console.log(error);
            }
        },
        async create() {
            
            this.expenses.user_id = this.loggedInUserId;

            await this.axios.post("http://127.0.0.1:8000/api/expenses/", this.expenses)
                .then(response => {
                    console.log(response.data); 
                    this.getExpenses(); 
                    this.expenses = { amount: "", category_id: null, user_id: null, entry_date: "" }; 
                })
                .catch(error => {
                    console.log(error);
                });
        },
        openEditExpensesModal(expense) {
            this.expenses = { ...expense }; 
            const editModal = new bootstrap.Modal(document.getElementById("editExpensesModal"));
            editModal.show(); // Show the edit modal
        },
        async editExpenses(id) {
            await this.axios.put(`http://127.0.0.1:8000/api/expenses/${id}/`, this.expenses)
                .then(response => {
                    console.log(response.data); 
                    this.getExpenses(); 
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async deleteExpenses(id) {
            await this.axios.delete(`http://127.0.0.1:8000/api/expenses/${id}/`)
                .then(response => {
                    console.log(response.data); 
                    this.getExpenses(); 
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
};
</script>
