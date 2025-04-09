<template>
    <div class="flex justify-between items-center bg-white shadow p-4 mb-6 rounded-xl">
        <h1 class="text-2xl font-bold text-gray-800">Translation Manager</h1>
        <button @click="logout" class="btn-secondary">Logout</button>
    </div>
</template>

<script>
export default {
    methods: {
        logout() {
            localStorage.removeItem('token');
            this.$router.push('/login');
        },
    },
};
</script>