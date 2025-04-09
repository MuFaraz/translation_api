<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 space-y-6">
            <h2 class="text-2xl font-bold text-center text-gray-800">Sign In to Your Account</h2>
            <form @submit.prevent="login" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" v-model="email" required
                        class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="you@example.com" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" v-model="password" required minlength="6"
                        class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                         />
                </div>

                <div v-if="error" class="text-sm text-red-600 text-center">
                    {{ error }}
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-200">
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from '../axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            error: null,
        };
    },
    methods: {
        async login() {
            this.error = null;
            if (!this.email || !this.password) {
                this.error = 'Please fill in all fields.';
                return;
            }

            try {
                const res = await axios.post('/login', {
                    email: this.email,
                    password: this.password,
                });

                localStorage.setItem('token', res.data.access_token);
                this.$router.push('/translations');
            } catch (err) {
                this.error = 'Invalid credentials. Please try again.';
            }
        },
    },
};
</script>