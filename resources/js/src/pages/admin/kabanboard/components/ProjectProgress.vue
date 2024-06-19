<template>
    <div class="w-full h-5 bg-neutral-200 dark:bg-neutral-400 rounded-full" aria-label="Ejemplo de label" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">
        <div class="flex justify-center items-center rounded-full h-5 bg-green-600 text-center text-xs font-bold leading-none"
            :style="{ width: projectData.data?.task_progress.progress + '%'}">
            <span class="text-sm">{{ projectData.data?.task_progress.progress + '%' }}</span>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ISingleProjectResponse } from '../interfaces/ProjectDetailInterface';

defineProps<{
    projectData: ISingleProjectResponse;
}>();
</script>

<style scoped>

</style>