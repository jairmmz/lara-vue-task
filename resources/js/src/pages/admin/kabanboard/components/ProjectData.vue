<template>
    <div class="m-3">
        <div class="flex items-center">
            <h3 class="text-xl">Proyecto: </h3>
            <span class="text-lg pl-1">{{ projectData.data?.project.name }}</span>
        </div>
        <div class="flex items-center">
            <div class="mr-4">
                <span class="text-xl">Fecha de inicio: </span>
                <span>{{ projectData.data?.project.start_date }}</span>
            </div>
            <div>
                <span class="text-xl">Fecha de término: </span>
                <span>{{ projectData.data?.project.start_date }}</span>
            </div>
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