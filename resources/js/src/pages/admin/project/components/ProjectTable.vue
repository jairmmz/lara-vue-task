<template>
    <div class="container-fluid">
        <div>
            <input type="text" @keydown="search" v-model="query" placeholder="Buscar miembro ..." class="inline-block mr-2 w-80 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <span v-show="isLoading">Buscando ...</span>
        </div>
        <div class="container-fluid">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terminación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Editar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fijado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ver</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="project in projects?.data.data" :key="project.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ (project.id).substring(0, 7) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ project.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="5" aria-valuemin="0" :aria-valuemax="100">
                                <div class="progress-bar bg-green-600" :style="{ width: project.task_progress?.progress + '%'}">
                                    {{ project.task_progress?.progress + '%' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button @click="emit('editProject', project)"  type="button" class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Editar</button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button @click="emit('pinnedProject', project.id)" type="button" class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">Fijar</button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <RouterLink :to="`/kaban?query=${project.slug}`" class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                                Ver <i></i>
                            </RouterLink>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <slot name="pagination"></slot>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { IGetProjects, IProject } from '../interfaces/ProjectInterface';
import { myDebounce } from '../../../../helpers/utils';

const query = ref<string>('');

defineProps<{
    projects: IGetProjects | undefined;
    isLoading: boolean;
}>();

const emit = defineEmits<{
    (event: 'pinnedProject', projectId: string): void;
    (event: 'editProject', project: IProject): void;
    (event: 'viewProjectDetail', projectId: string): void;
    (event: 'getProjects', page: number, query: string): Promise<void>;
}>();

const search = myDebounce(async () => {
    await emit('getProjects', 1, query.value);
}, 2000);
</script>

<style scoped></style>