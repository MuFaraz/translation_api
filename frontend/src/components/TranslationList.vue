<template>
    <div class="p-6 max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Translation Manager</h1>
        <!-- Add Translation -->
        <div class="bg-white rounded-xl p-4 shadow mb-6">
            <h2 class="text-xl font-semibold mb-3">Add New Translation</h2>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <input v-model="newTranslation.key" placeholder="Key" class="input-field" />
                <input v-model="newTranslation.locale" placeholder="Locale" class="input-field" />
                <input v-model="newTranslation.value" placeholder="Value" class="input-field" />
                <input v-model="newTranslation.tag" placeholder="Tag" class="input-field" />
            </div>
            <button @click="addTranslation" class="btn-success mt-4">Add</button>
        </div>
        <div class="bg-white rounded-xl p-4 shadow mb-6 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium mb-1">Key</label>
                <input v-model="filters.key" type="text" placeholder="Search key..." class="input-field" />
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium mb-1">Locale</label>
                <input v-model="filters.locale" type="text" placeholder="en" class="input-field" />
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium mb-1">Tag</label>
                <input v-model="filters.tag" type="text" placeholder="web.." class="input-field" />
            </div>
            <button @click="fetchTranslations" class="btn-primary mt-5">Search</button>
        </div>



        <!-- Translations Table -->
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Key</th>
                        <th class="px-4 py-2">Locale</th>
                        <th class="px-4 py-2">Value</th>
                        <th class="px-4 py-2">Tag</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="t in translations.data" :key="t.id"
                        class="border-t hover:bg-gray-50 transition duration-200">
                        <td class="px-4 py-2">{{ t.key }}</td>
                        <td class="px-4 py-2">{{ t.locale }}</td>
                        <td class="px-4 py-2">{{ t.value }}</td>
                        <td class="px-4 py-2">{{ t.tag }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div v-if="translations.meta" class="flex items-center justify-between mt-4">
            <button @click="changePage(translations.meta.current_page - 1)"
                :disabled="translations.meta.current_page === 1" class="btn-secondary">
                Prev
            </button>
            <span class="text-sm">
                Page {{ translations.meta.current_page }} of {{ translations.meta.last_page }}
            </span>
            <button @click="changePage(translations.meta.current_page + 1)"
                :disabled="translations.meta.current_page === translations.meta.last_page" class="btn-secondary">
                Next
            </button>
        </div>

        <!-- Export JSON -->
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

export default {
    name: 'TranslationManager',
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

                const blob = new Blob([JSON.stringify(res.data, null, 2)], {
                    type: 'application/json',
                });
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

<style scoped>
.input-field {
    @apply w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
}

.btn-primary {
    @apply bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition;
}

.btn-success {
    @apply bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition;
}

.btn-secondary {
    @apply bg-gray-300 px-3 py-1 rounded hover:bg-gray-400 disabled:opacity-50;
}

.btn-purple {
    @apply bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition;
}
</style>