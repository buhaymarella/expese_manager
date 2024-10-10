<template>
    
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card text-start shadow p-4 mt-5" style="width: 20rem;">
            <h2 class="h2">Login</h2>
            <form @submit.prevent="handleLogin">
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input
                        type="text"
                        v-model="users.email"
                        class="form-control"
                    />
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        v-model="users.password"
                        class="form-control"
                    />
                    <router-link
                        to="/forgotPass"
                        class="text-dark small text-decoration-none d-flex justify-content-end"
                        >Forgot Password?</router-link
                    >
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    Login
                </button>
                <hr />
                <router-link to="/signUp">
                    <button type="button" class="btn btn-outline-primary w-100">
                        Sign up
                    </button>
                </router-link>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            users: {
                email: "",
                password: "",
            },
        };
    },
    methods: {
    async handleLogin() {
        try {
            const response = await this.axios.post(
                "http://127.0.0.1:8000/api/login",
                {
                    email: this.users.email,
                    password: this.users.password,
                }
            );

            console.log(response.data); 

            if (response.data.success) {
                const user = response.data.data; 

                if (user) {
                    
                    sessionStorage.setItem('loggedInUserId', user.id); 

                    
                    if (user.role_id === 1) {
                        this.$router.push({ name: "dashboard" });
                    } else if (user.role_id === 3) {
                        this.$router.push({ name: "userDashboard" });
                    } else {
                        alert("Access Denied: You do not have the appropriate role.");
                    }
                } else {
                    alert("User data not found in response.");
                }
            } else {
                alert("Login failed. Please check your credentials.");
            }
        } catch (error) {
            console.log(error.response); 
            alert("Login failed. Please check your credentials.");
        }
    },
},



};
</script>
