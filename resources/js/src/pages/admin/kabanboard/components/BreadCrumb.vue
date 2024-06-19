<template>
    <nav class="relative flex w-full flex-wrap items-center justify-between bg-zinc-50 py-2 shadow-dark-mild dark:bg-neutral-700 lg:py-4">
        <div class="flex w-full flex-wrap items-center justify-between px-3">
            <nav class="w-full rounded-md" aria-label="breadcrumb">
                <ol class="list-reset ms-2 flex">
                    <li>
                        <RouterLink :to="{ name: 'create.project' }" class="motion-reduce:transition-none-none text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80">Crear proyecto</RouterLink>
                    </li>
                    <li>
                        <span class="mx-2 text-black/60 dark:text-white/60">/</span>
                    </li>
                    <li>
                        <RouterLink :to="{ name: 'projects' }" class="motion-reduce:transition-none-none text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80">Proyectos</RouterLink>
                    </li>
                </ol>
            </nav>
        </div>
    </nav>
</template>

<script setup lang="ts">

</script>

<style scoped>

</style>