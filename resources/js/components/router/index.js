import { createRouter, createWebHistory } from "vue-router";

// Lazy loading components
const UserRole = () => import('../expenses/UserRole.vue');
const ExpenseCategory = () => import('../expenses/ExpenseCategory.vue');
const Login = () => import('../expenses/Login.vue');
const SignUp = () => import('../expenses/SignUp.vue');
const ForgotPass = () => import('../expenses/ForgotPass.vue');
const Users = () => import('../expenses/Users.vue');
const Expenses = () => import('../expenses/Expenses.vue');
const Dashboard = () =>import('../expenses/Dashboard.vue');
const Pie = () => import('../expenses/PieChart.vue');
const UserExpense = () => import('../expenses/user/UserExpenses.vue');
const UserDashboard = () => import('../expenses/user/userDashboard.vue');

const routes = [
    {
        name: 'home',
        path: '/',
        component: Login
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'signUp',
        path: '/signUp',
        component: SignUp
    },
    {
        name: 'forgotPass',
        path: '/forgotPass',
        component: ForgotPass
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'userRole',
        path: '/userRole',
        component: UserRole
    },
    {
        name: 'userExpense',
        path: '/userExpense',
        component: UserExpense
    },
    {
        name: 'userDashboard',
        path: '/userDashboard',
        component: UserDashboard
    },
    {
        name: 'users',
        path: '/users',
        component: Users
    },
    {
        name: 'expenseCategory',
        path: '/expenseCategory',
        component: ExpenseCategory
    },
    {
        name: 'Expenses',
        path: '/expenses',
        component: Expenses
    },
    {
        name: 'pie',
        path: '/pie',
        component: Pie
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
