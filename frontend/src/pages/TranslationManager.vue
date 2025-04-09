<template>
    <div class="p-6 max-w-7xl mx-auto">
        <Navbar />
        <TranslationForm :translation="newTranslation" @submit="addTranslation" />
        <TranslationFilters :filters="filters" @search="fetchTranslations" />
        <TranslationTable :data="translations.data" />
        <Pagination v-if="translations.meta" :meta="translations.meta" @change="changePage" />
        <div class="mt-8">
            <label class="block text-sm font-medium mb-1">Export Locale</label>
            <div class="flex gap-2">
                <input v-model="exportLocale" placeholder="e.g., en" class="input-field w-1/3" />
                <button @click="exportJSON" class="btn-purple">Export JSON</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from '../axios';
import Navbar from '../components/Navbar.vue';
import TranslationForm from '../components/TranslationForm.vue';
import TranslationFilters from '../components/TranslationFilters.vue';
import TranslationTable from '../components/TranslationTable.vue';
import Pagination from '../components/Pagination.vue';

export default {
    components: {
        Navbar,
        TranslationForm,
        TranslationFilters,
        TranslationTable,
        Pagination,
    },
    data() {
        return {
            filters: { key: '', tag: '', locale: '' },
            newTranslation: { key: '', locale: '', value: '', tag: '' },
            exportLocale: '',
            translations: { data: [], meta: null },
            page: 1,
        };
    },
    methods: {
        getAuthHeaders() {
            const token = localStorage.getItem('token');
            return { Authorization: `Bearer ${token}` };
        },
        async fetchTranslations() {
            const response = await axios.get('/translations', {
                headers: this.getAuthHeaders(),
                params: { ...this.filters, page: this.page },
            });

            this.translations = {
                data: response.data.data,
                meta: {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                },
            };
        },
        async addTranslation() {
            try {
                await axios.post('/translations', this.newTranslation, {
                    headers: this.getAuthHeaders(),
                });
                this.newTranslation = { key: '', locale: '', value: '', tag: '' };
                this.fetchTranslations();
            } catch (err) {
                alert('Failed to add translation');
            }
        },
        changePage(newPage) {
            this.page = newPage;
            this.fetchTranslations();
        },
        async exportJSON() {
            try {
                const res = await axios.get(`/translations/export/${this.exportLocale}`, {
                    headers: this.getAuthHeaders(),
                });
                const blob = new Blob([JSON.stringify(res.data, null, 2)], { type: 'application/json' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `${this.exportLocale}_translations.json`;
                link.click();
            } catch (err) {
                alert('Export failed');
            }
        },
    },
    mounted() {
        this.fetchTranslations();
    },
};
</script>