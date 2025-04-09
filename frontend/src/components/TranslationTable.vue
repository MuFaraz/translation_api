<template>
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
                <tr v-for="t in data" :key="t.id" class="border-t hover:bg-gray-50 transition duration-200">
                    <td class="px-4 py-2">{{ t.key }}</td>
                    <td class="px-4 py-2">{{ t.locale }}</td>
                    <td class="px-4 py-2">{{ t.value }}</td>
                    <td class="px-4 py-2">{{ t.tag }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['data'],
};
</script>