<template>
    <div class="p-4 max-w-sm mx-auto">
        <h2 class="text-xl mb-4">Login</h2>
        <form @submit.prevent="login">
            <input v-model="email" type="email" placeholder="Email" class="mb-2 w-full" />
            <input v-model="password" type="password" placeholder="Password" class="mb-2 w-full" />
            <button class="bg-blue-500 text-white px-4 py-2">Login</button>
        </form>
    </div>
</template>

<script>
import axios from '../axios';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {
            try {
                const res = await axios.post('/login', {
                    email: this.email,
                    password: this.password,
                });
                localStorage.setItem('token', res.data.access_token);
                this.$router.push('/translate');
            } catch (err) {
                alert('Login failed');
            }
        },
    },
};
</script>