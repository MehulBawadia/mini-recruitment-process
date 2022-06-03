<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    processing: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <button :type="type" class="font-bold inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md text-sm text-white tracking-widest hover:bg-amber-600 focus:bg-amber-600 focus:outline-none transition ease-in-out duration-150" :processing="processing">
        <slot />
    </button>
</template>
