<template>
    <div>
        <h3>Translations</h3>
        <ul v-if="translations.length">
            <li v-for="item in translations" :key="item.id">{{ item.key }} - {{ item.value }}</li>
        </ul>
    </div>
</template>

<script>
import api from '../api';
export default {
    data() {
        return { translations: [] };
    },
    async created() {
        const res = await api.get('/translations');
        this.translations = res.data.data;
    },
};
</script>
