<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Translation Manager</h1>

        <!-- Filters -->
        <div class="flex gap-4 mb-4">
            <input v-model="filters.key" type="text" placeholder="Search key..." class="border p-2 rounded w-1/3" />
            <input v-model="filters.locale" type="text" placeholder="Locale (en, fr...)"
                class="border p-2 rounded w-1/4" />
            <input v-model="filters.tag" type="text" placeholder="Tag (web, mobile...)"
                class="border p-2 rounded w-1/4" />
            <button @click="fetchTranslations" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
        </div>

        <!-- Add New -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">Add New Translation</h2>
            <div class="grid grid-cols-4 gap-2">
                <input v-model="newTranslation.key" placeholder="Key" class="border p-2 rounded" />
                <input v-model="newTranslation.locale" placeholder="Locale" class="border p-2 rounded" />
                <input v-model="newTranslation.value" placeholder="Value" class="border p-2 rounded" />
                <input v-model="newTranslation.tags" placeholder="Tags (comma separated)" class="border p-2 rounded" />
            </div>
            <button @click="addTranslation" class="bg-green-600 text-white px-4 py-2 mt-2 rounded">Add</button>
        </div>

        <!-- Table -->
        <table class="min-w-full border mt-4">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 text-left">Key</th>
                    <th class="p-2 text-left">Locale</th>
                    <th class="p-2 text-left">Value</th>
                    <th class="p-2 text-left">Tags</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="t in translations.data" :key="t.id" class="border-t">
                    <td class="p-2">{{ t.key }}</td>
                    <td class="p-2">{{ t.locale }}</td>
                    <td class="p-2">{{ t.value }}</td>
                    <td class="p-2">{{ t.tags.join(', ') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="translations.meta" class="mt-4">
            <button @click="changePage(translations.meta.current_page - 1)"
                :disabled="translations.meta.current_page === 1"
                class="px-3 py-1 bg-gray-300 rounded mr-2">Prev</button>
            Page {{ translations.meta.current_page }} of {{ translations.meta.last_page }}
            <button @click="changePage(translations.meta.current_page + 1)"
                :disabled="translations.meta.current_page === translations.meta.last_page"
                class="px-3 py-1 bg-gray-300 rounded ml-2">Next</button>
        </div>

        <!-- Export -->
        <div class="mt-6">
            <input v-model="exportLocale" placeholder="Locale to export (e.g., en)"
                class="border p-2 rounded w-1/4 mr-2" />
            <button @click="exportJSON" class="bg-purple-600 text-white px-4 py-2 rounded">Export JSON</button>
        </div>
    </div>
</template>

<script>
import axios from '../axios';

export default {
    name: 'Translations',
    data() {
        return {
            filters: {
                key: '',
                tag: '',
                locale: '',
            },
            newTranslation: {
                key: '',
                locale: '',
                value: '',
                tags: '',
            },
            exportLocale: '',
            translations: {
                data: [],
                meta: null,
            },
            page: 1,
        };
    },
    methods: {
        getAuthHeaders() {
            const token = localStorage.getItem('token');
            return {
                Authorization: `Bearer ${token}`,
            };
        },
        async fetchTranslations() {
            const { key, tag, locale } = this.filters;
            const response = await axios.get('/translations', {
                headers: this.getAuthHeaders(),
                params: {
                    key,
                    tag,
                    locale,
                    page: this.page,
                },
            });
            this.translations = response.data;
        },
        async addTranslation() {
            try {
                const payload = {
                    ...this.newTranslation,
                    tags: this.newTranslation.tags.split(',').map(t => t.trim()),
                };

                await axios.post('/translations', payload, {
                    headers: this.getAuthHeaders(),
                });

                this.newTranslation = {
                    key: '',
                    locale: '',
                    value: '',
                    tags: '',
                };

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

<style scoped>
table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    border: 1px solid #ddd;
}
</style>