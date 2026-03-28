<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';

defineProps({
    errors: Object,
});

const form = useForm({
    name: '',
    password: '',
});

function submit() {
    form.post('/login', { preserveScroll: true });
}
</script>

<template>
    <GuestLayout>
        <template #links>
            <Link
                href="/register"
                class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
            >
                Register
            </Link>
        </template>

        <Head title="Login" />

        <div
            class="rounded-2xl border border-slate-200/80 bg-white/80 p-8 shadow-xl shadow-indigo-100/50 backdrop-blur dark:border-slate-700 dark:bg-slate-900/80 dark:shadow-none"
        >
            <h1 class="text-center text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
                Welcome back
            </h1>
            <p class="mt-1 text-center text-sm text-slate-500 dark:text-slate-400">
                Sign in with your username
            </p>

            <form class="mt-8 space-y-5" @submit.prevent="submit">
                <div
                    v-if="$page.props.flash?.success"
                    class="rounded-lg bg-emerald-50 px-3 py-2 text-sm text-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-100"
                >
                    {{ $page.props.flash.success }}
                </div>
                <div
                    v-if="$page.props.flash?.error"
                    class="rounded-lg bg-red-50 px-3 py-2 text-sm text-red-800 dark:bg-red-950/50 dark:text-red-200"
                >
                    {{ $page.props.flash.error }}
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Username</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        autocomplete="username"
                        required
                        class="mt-1.5 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none ring-indigo-500 transition focus:border-indigo-500 focus:ring-2 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-indigo-500"
                    />
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.name }}</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="mt-1.5 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none ring-indigo-500 transition focus:border-indigo-500 focus:ring-2 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-indigo-500"
                    />
                    <p v-if="errors.password" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.password }}</p>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 dark:focus:ring-offset-slate-900"
                    :disabled="form.processing"
                >
                    {{ form.processing ? 'Signing in…' : 'Sign in' }}
                </button>
            </form>
        </div>
    </GuestLayout>
</template>
