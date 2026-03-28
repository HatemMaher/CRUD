<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col bg-gradient-to-br from-indigo-50 via-white to-violet-50 dark:from-slate-950 dark:via-slate-900 dark:to-indigo-950"
    >
        <header class="px-4 py-4 sm:px-6">
            <div class="mx-auto flex max-w-lg items-center justify-between">
                <Link href="/" class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">Notes</Link>
                <nav class="flex gap-3 text-sm">
                    <slot name="links" />
                </nav>
            </div>
        </header>
        <div class="flex flex-1 items-center justify-center px-4 pb-16 pt-4">
            <div class="w-full max-w-md">
                <slot />
            </div>
        </div>
    </div>
</template>
