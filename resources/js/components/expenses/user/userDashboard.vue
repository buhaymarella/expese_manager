<template>
    <div class="row p-0 m-0">
        <div class="dashboard-layout col-2">
            <Sidebar />
        </div>
        <div class="main-content col-10 p-5">
            <h1>Dashboard</h1>
            <hr>
            <div class="row mt-5">
                <div class="col-12 col-lg-4 text-center text-lg-start" v-if="aggregatedExpensesList.length > 0">
                    <div class="d-flex gap-5">
                        <div>
                            <h5 class="h5">Expense Category</h5>
                            <p v-for="(expense, index) in aggregatedExpensesList" :key="index" >{{ expense.category.expenseCategory }}</p>
                        </div>
                        <div>
                            <h5 class="h5">Amount</h5>
                            <p v-for="(expense, index) in aggregatedExpensesList" :key="index">$ {{ formatAmount(expense.amount) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <pie-chart :data="formattedPieChartData"></pie-chart>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from "./UserSideBar.vue";

export default {
    name: "Expenses",
    components: { Sidebar },
    data() {
        return {
            expensesList: [],
            loggedInUserId: null,
        };
    },
    mounted() {
        this.loggedInUserId = Number(sessionStorage.getItem('loggedInUserId')) || null;
        this.fetchInitialData();
    },
    computed: {
        aggregatedExpensesList() {
            const categoryTotals = {};

            this.expensesList.forEach(expense => {
                if (expense.user_id === this.loggedInUserId) {
                    const category = expense.category?.expenseCategory;
                    const amount = parseFloat(expense.amount) || 0;

                    if (category) {
                        categoryTotals[category] = (categoryTotals[category] || 0) + amount;
                    }
                }
            });

            return Object.entries(categoryTotals).map(([category, totalAmount]) => ({
                category: { expenseCategory: category },
                amount: totalAmount,
            }));
        },
        formattedPieChartData() {
            return this.aggregatedExpensesList.map(expense => [
                expense.category.expenseCategory,
                expense.amount
            ]);
        }
    },
    methods: {
        async fetchInitialData() {
            try {
                await Promise.all([this.getExpenses(), this.getUsers(), this.getCategory()]);
            } catch (error) {
                console.error('Error fetching initial data:', error);
            }
        },
        async getExpenses() {
            try {
                const response = await this.axios.get("http://127.0.0.1:8000/api/expenses/");
                this.expensesList = response.data;
            } catch (error) {
                console.error('Error fetching expenses:', error);
                this.expensesList = [];
            }
        },
        async getUsers() {
            try {
                const response = await this.axios.get("http://127.0.0.1:8000/api/users/");
                this.users = response.data; 
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        async getCategory() {
            try {
                const response = await this.axios.get("http://127.0.0.1:8000/api/expenseCategory/");
                this.category = response.data; 
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        },
        formatAmount(amount) {
            return isNaN(amount) ? '0.00' : amount.toFixed(2);
        },
    },
};
</script>
