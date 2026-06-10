<script setup>
defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    title: {
        type: String,
        default: 'Confirm Action',
    },
    message: {
        type: String,
        default: 'Are you sure?',
    },
});

const emit = defineEmits(['close', 'confirm']);
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
    >
        <div
            class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-900"
        >
            <h3
                class="text-lg font-semibold text-slate-900 dark:text-white"
            >
                {{ title }}
            </h3>

            <p
                class="mt-3 text-slate-600 dark:text-slate-300"
            >
                {{ message }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm hover:bg-slate-100 dark:border-slate-700 dark:hover:bg-slate-800"
                    @click="$emit('close')"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-500"
                    @click="$emit('confirm')"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>