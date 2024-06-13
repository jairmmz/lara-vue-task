<template>
    <section class="flex items-center h-screen min-w-full max-w-full p-16 bg-gray-50 dark:bg-gray-700">
        <div class="container flex flex-col items-center ">
            <div class="flex flex-col gap-6 max-w-md text-center">
                <h2 class="font-extrabold text-9xl text-gray-600 dark:text-gray-100">
                    <span class="sr-only">Error</span>404
                </h2>
                <p class="text-2xl md:text-3xl dark:text-gray-300">Lo sentimos, no pudimos encontrar esta página.</p>
                <button type="button" @click="backPage" class="px-8 py-4 text-xl font-semibold rounded bg-purple-600 text-gray-50 hover:text-gray-200">Regresar atrás</button>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router';

const router = useRouter();
const backPage = () => {
    router.back();
}
</script>

<style scoped></style>