<script setup>
import { computed, onMounted, watch } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();

const user = computed(() => page.props.auth?.user);
const flash = computed(() => page.props.flash);

function applyTheme(theme) {
    const root = document.documentElement;
    if (theme === 'dark') {
        root.classList.add('dark');
    } else {
        root.classList.remove('dark');
    }
}

onMounted(() => {
    if (user.value) {
        applyTheme(user.value.theme);
    }
});

watch(
    () => user.value?.theme,
    (t) => {
        if (t) applyTheme(t);
    },
);

async function toggleTheme() {
    if (!user.value) return;
    const next = user.value.theme === 'light' ? 'dark' : 'light';
    applyTheme(next);
    await fetch('/theme-toggle', {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
        },
        body: JSON.stringify({ theme: next }),
    });
    router.reload({ only: ['auth'] });
}

function logout() {
    router.post('/logout');
}
</script>

<template>
    <div
        class="min-h-screen bg-slate-50 text-slate-900 transition-colors dark:bg-slate-950 dark:text-slate-100"
    >
        <header
            class="border-b border-slate-200/80 bg-white/90 backdrop-blur dark:border-slate-800 dark:bg-slate-900/90"
        >
            <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
                <Link
                    href="/"
                    class="text-lg font-semibold tracking-tight text-indigo-600 dark:text-indigo-400"
                >
                    Notes
                </Link>
                <div v-if="user" class="flex items-center gap-3">
                    <span class="hidden text-sm text-slate-600 dark:text-slate-400 sm:inline">
                        {{ user.name }}
                    </span>
                    <button
                        type="button"
                        class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
                        @click="toggleTheme"
                    >
                        {{ user.theme === 'dark' ? 'Light' : 'Dark' }}
                    </button>
                    <button
                        type="button"
                        class="rounded-lg bg-slate-900 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-indigo-600 dark:hover:bg-indigo-500"
                        @click="logout"
                    >
                        Log out
                    </button>
                </div>
            </div>
        </header>

        <div
            v-if="flash?.success"
            class="mx-auto max-w-5xl px-4 pt-4 sm:px-6"
        >
            <div
                class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 dark:border-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-100"
            >
                {{ flash.success }}
            </div>
        </div>

        <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
            <slot />
        </main>

        <footer class="mt-auto border-t border-slate-200/80 py-6 text-center text-sm text-slate-500 dark:border-slate-800 dark:text-slate-500">
            &copy; {{ new Date().getFullYear() }} Notes · All rights reserved.
        </footer>
    </div>
</template>
