<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
    post: Object,
    errors: Object,
});

const form = useForm({
    title: props.post.title,
    body: props.post.body,
});

function submit() {
    form.put(`/notes/${props.post.id}`, { preserveScroll: true });
}
</script>

<template>
    <AppLayout>
        <Head :title="`Edit · ${post.title}`" />

        <div class="space-y-6">
            <div>
                <Link
                    href="/"
                    class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                >
                    ← Back to notes
                </Link>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Edit note
                </h1>
            </div>

            <form
                class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900/50"
                @submit.prevent="submit"
            >
                <div class="space-y-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Title</label>
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            class="mt-1.5 w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                        />
                        <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
                    </div>
                    <div>
                        <label for="body" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Content</label>
                        <textarea
                            id="body"
                            v-model="form.body"
                            rows="14"
                            class="mt-1.5 w-full resize-y rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                        />
                        <p v-if="errors.body" class="mt-1 text-sm text-red-600">{{ errors.body }}</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <button
                        type="submit"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? 'Saving…' : 'Save changes' }}
                    </button>
                    <Link
                        href="/"
                        class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
