<script lang="ts" setup>
defineProps<{
    loading: boolean;
    label: string;
}>();
</script>

<template>
    <button :disabled="loading" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        <span v-if="loading ? false : true"> {{ label }}</span>
        <div v-if="loading ? true : false">
            <span>Cargando...</span>
        </div>
    </button>
</template>