<template>
    <form @submit.prevent="submit">
        <input v-model="form.key" placeholder="Key" />
        <input v-model="form.value" placeholder="Value" />
        <input v-model="form.locale" placeholder="Locale" />
        <input v-model="form.tag" placeholder="Tag" />
        <button type="submit">Add</button>
    </form>
</template>

<script>
import api from '../api';
export default {
    data() {
        return {
            form: { key: '', value: '', locale: '', tag: '' }
        };
    },
    methods: {
        async submit() {
            await api.post('/translations', this.form);
            alert('Added!');
        }
    }
};
</script>