<template>
    <div class="flex items-center justify-between mt-4">
        <button @click="$emit('change', meta.current_page - 1)" :disabled="meta.current_page === 1"
            class="btn-secondary">
            Prev
        </button>
        <span class="text-sm">Page {{ meta.current_page }} of {{ meta.last_page }}</span>
        <button @click="$emit('change', meta.current_page + 1)" :disabled="meta.current_page === meta.last_page"
            class="btn-secondary">
            Next
        </button>
    </div>
</template>

<script>
export default {
    props: ['meta'],
};
</script>