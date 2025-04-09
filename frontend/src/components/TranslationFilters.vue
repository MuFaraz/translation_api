<template>
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
        <button @click="$emit('search')" class="btn-primary mt-5">Search</button>
    </div>
</template>

<script>
export default {
    props: ['filters'],
};
</script>