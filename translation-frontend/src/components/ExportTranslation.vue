<template>
    <div>
        <input v-model="locale" placeholder="Locale" />
        <button @click="exportTranslations">Export</button>
        <pre>{{ result }}</pre>
    </div>
</template>

<script>
import api from '../api';
export default {
    data() {
        return { locale: 'en', result: null };
    },
    methods: {
        async exportTranslations() {
            const res = await api.get(`/translations/export/${this.locale}`);
            this.result = res.data;
        }
    }
};
</script>