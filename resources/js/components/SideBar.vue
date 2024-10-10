<!-- Sidebar.vue -->
<template>
    <div class="row container-fluid">
        <div class="sidebar bg-dark p-3 col-1">
        <h6 class="h6 text-white">Admin (admin)</h6>
        <ul>
            <li>
                <router-link to="/dashboard" class="text-white text-decoration-none">Dashboard</router-link>
            </li>
            <li class="text-white">
                User Management
                <ul class="mx-3">
                    <li>
                        <router-link
                            class="text-white text-decoration-none"
                            to="/userRole"
                            >User Roles</router-link
                        >
                    </li>
                    <li>
                        <router-link
                            class="text-white text-decoration-none"
                            to="/users"
                            >Users</router-link
                        >
                    </li>
                </ul>
            </li>
            <li class="text-white">
                Expense Management
                <ul class="mx-3">
                    <li>
                        <router-link
                            class="text-white text-decoration-none"
                            to="/expenseCategory"
                            >Expense Categories</router-link
                        >
                    </li>
                    <li>
                        <router-link
                            class="text-white text-decoration-none"
                            to="/expenses"
                            >Expenses</router-link
                        >
                    </li>
                </ul>
            </li>
            <li class="align-item-end"><router-link to="/login" class="text-white text-decoration-none">Logout</router-link></li>
        </ul>
        </div>
    </div>

    <router-view/>
</template>

<script>
export default {
    name: "Sidebar",
};
</script>

<style scoped>
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #f8f9fa;
    position: fixed;
    top: 0;
    left: 0;
}
ul {
    list-style-type: none;
    padding: 0;
}
li {
    margin: 20px 0;
}
</style>
