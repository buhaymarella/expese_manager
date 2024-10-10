<template>
    <div class="row p-0 m-0">
        <div class="dashboard-layout col-2">
            <Sidebar />
            <div class="main-content">
                <router-view />
            </div>
        </div>
        <div class="container col-10 p-5">
            <h1>Dashboard</h1>
            <hr>
            <div class="row mt-2 mt-lg-5">
                <div class="col-12 col-lg-4" v-if="filteredExpensesList.length > 0">
                    <div class="d-flex gap-2 gap-lg-5">
                        <div>
                            <h5 class="h5">Expense Category</h5>
                            <p v-for="(expense, key) in filteredExpensesList" :key="key" >
                                {{ expense.category.expenseCategory }}
                            </p>
                        </div>
                        <div>
                            <h5 class="h5">Amount</h5>
                            <p v-for="(expense, key) in filteredExpensesList" :key="key">
                                $ {{ parseFloat(expense.amount).toFixed(2) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8" >
                    <pie-chart :data="formattedPieChartData()"></pie-chart>
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
            filteredExpensesList: [],
            expenses: {
                amount: "",
                category_id: null,
                user_id: null,
                entry_date: "",
            },
            users: [],
            category: [],
        };
    },
    mounted() {
        this.getExpenses();
        this.getCategory();
    },
    methods: {
        async getExpenses() {
            await this.axios
                .get("http://127.0.0.1:8000/api/expenses/")
                .then((response) => {
                    this.expensesList = response.data;
                    this.filteredExpensesList = this.sumAmountsByCategory(this.expensesList);
                })
                .catch((error) => {
                    console.log(error);
                    this.expensesList = [];
                });
        },
        async getCategory() {
            try {
                const response = await this.axios.get("http://127.0.0.1:8000/api/expenseCategory/");
                this.category = response.data;
            } catch (error) {
                console.log(error);
            }
        },
        sumAmountsByCategory(expenses) {
            const categoryTotals = {};

            expenses.forEach((expense) => {
                const category = expense.category.expenseCategory;
                const amount = parseFloat(expense.amount); 

                if (categoryTotals[category]) {
                    categoryTotals[category] += amount;
                } else {
                
                    categoryTotals[category] = amount;
                }
            });

            return Object.entries(categoryTotals).map(([category, totalAmount]) => ({
                category: { expenseCategory: category },
                amount: totalAmount,
            }));
        },
        formattedPieChartData() {
            const data = this.filteredExpensesList.map(expense => [
                expense.category.expenseCategory,
                parseFloat(expense.amount).toFixed(2)
            ]);

            return data;
        }
    },
};
</script>
