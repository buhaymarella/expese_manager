<template>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card w-25 text-start shadow-sm p-3">
            <h2 class="h2">Forgot Password</h2>
            <form @submit.prevent="updatePassword">
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control"  required>
                </div>
                <div class="mb-3">
                    <label for="password">New Password</label>
                    <input type="password" name="password" class="form-control"  required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <router-link to="/" class=" text-dark text-decoration-none">
                        <button type="button" class="btn btn-outline-dark">Go Back</button>
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
</script>
