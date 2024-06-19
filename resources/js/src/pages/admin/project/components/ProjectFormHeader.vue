<template>
    <div class="flex justify-between items-center">
        <h2 class="mb-10 text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ isEdit ? updatedName : createdName }}</h2>
        <button type="button" @click="emit('backPage')" class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
            Regresar
        </button>
    </div>
</template>

<script setup lang="ts">

defineProps<{
    isEdit: boolean;
    createdName: string;
    updatedName: string;
}>();

const emit = defineEmits<{
    (event: 'backPage'): void;
}>();
</script>

<style scoped>

</style>