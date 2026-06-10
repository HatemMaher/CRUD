<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
import { ref } from 'vue';
import ConfirmationModal from '../../Components/ConfirmationModal.vue';

const props = defineProps({
    posts: Array,
    errors: Object,
});

const form = useForm({
    title: '',
    body: '',
});

const showDeleteModal = ref(false);
const noteToDelete = ref(null);

function createNote() {
    form.post('/notes', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}

function confirmDelete(id) {
    noteToDelete.value = id;
    showDeleteModal.value = true;
}

function destroy() {
    router.delete(`/notes/${noteToDelete.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            noteToDelete.value = null;
        },
    });
}

function closeDeleteModal() {
    showDeleteModal.value = false;
    noteToDelete.value = null;
}

function formatDate(iso) {
    if (!iso) return '';
    const d = new Date(iso);
    return d.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
}
</script>

<template>
    <AppLayout>
        <Head title="Your notes" />

        <div class="space-y-10">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Your notes
                </h1>
                <p class="mt-1 text-slate-600 dark:text-slate-400">
                    Quick capture, edit anytime — everything stays private to your account.
                </p>
            </div>

            <section
                class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900/50"
            >
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">New note</h2>
                <form class="mt-4 space-y-4" @submit.prevent="createNote">
                    <div>
                        <label for="title" class="sr-only">Title</label>
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            placeholder="Title"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500"
                        />
                        <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
                    </div>
                    <div>
                        <label for="body" class="sr-only">Content</label>
                        <textarea
                            id="body"
                            v-model="form.body"
                            rows="4"
                            placeholder="Write something…"
                            class="w-full resize-y rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500"
                        />
                        <p v-if="errors.body" class="mt-1 text-sm text-red-600">{{ errors.body }}</p>
                    </div>
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:opacity-50"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Saving…' : 'Save note' }}
                        </button>
                    </div>
                </form>
            </section>

            <section v-if="posts.length === 0" class="rounded-2xl border border-dashed border-slate-300 py-16 text-center dark:border-slate-700">
                <p class="text-slate-500 dark:text-slate-400">No notes yet. Add one above.</p>
            </section>

            <ul v-else class="space-y-4">
                <li
                    v-for="post in posts"
                    :key="post.id"
                    class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:border-indigo-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-indigo-900"
                >
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                                {{ post.title }}
                            </h3>
                            <p class="mt-2 whitespace-pre-wrap text-slate-600 dark:text-slate-300">
                                {{ post.body }}
                            </p>
                            <p class="mt-3 text-xs text-slate-400">
                                Updated {{ formatDate(post.updated_at) }}
                            </p>
                        </div>
                        <div class="flex shrink-0 gap-2 sm:flex-col sm:items-end">
                            <Link
                                :href="`/notes/${post.id}/edit`"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800"
                            >
                                Edit
                            </Link>
                            <button
                                type="button"
                                class="inline-flex items-center justify-center rounded-lg border border-red-200 px-3 py-1.5 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-900/50 dark:text-red-400 dark:hover:bg-red-950/30"
                                @click="confirmDelete(post.id)"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <ConfirmationModal
            :show="showDeleteModal"
            title="Delete Note"
            message="Are you sure you want to delete this note? This action cannot be undone."
            @close="closeDeleteModal"
            @confirm="destroy"
        />
    </AppLayout>
</template>
