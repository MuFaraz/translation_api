<template>
    <div class="bg-white rounded-xl p-4 shadow mb-6">
        <h2 class="text-xl font-semibold mb-3">Add New Translation</h2>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <input v-model="translation.key" placeholder="Key" class="input-field" />
            <input v-model="translation.locale" placeholder="Locale" class="input-field" />
            <input v-model="translation.value" placeholder="Value" class="input-field" />
            <input v-model="translation.tag" placeholder="Tag" class="input-field" />
        </div>
        <button @click="submit" class="btn-success mt-4">Add</button>
    </div>
</template>

<script>
export default {
    props: ['translation'],
    emits: ['submit'],
    methods: {
        submit() {
            this.$emit('submit');
        },
    },
};
</script>