<template>
    <div class="container-fluid">
        <div>
            <input type="text" @keydown="search" v-model="query" placeholder="Buscar proyecto ..." class="inline-block mr-2 w-80 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <span v-show="isLoading">Buscando ...</span>
        </div>
        <div class="container-fluid">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="font-bold">
                        <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Terminación</th>
                        <th class="px-3 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Editar</th>
                        <th class="pr-px py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Fijado</th>
                        <th class="pr-px py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Ver</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="project in projects?.data.data" :key="project.id">
                        <td class="px-3 py-4 whitespace-nowrap">{{ (project.id).substring(0, 7) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ project.name }}</td>
                        <td class="">
                            <div class="w-full bg-neutral-200 dark:bg-neutral-400 rounded-full" aria-label="Ejemplo de label" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">
                                <div class="rounded-full bg-green-600 text-center text-xs font-bold leading-none"
                                    :style="{ width: project.task_progress?.progress + '%'}">
                                    {{ project.task_progress?.progress + '%' }}
                                </div>
                            </div>
                        </td>
                        <td class="pl-3 py-4 whitespace-nowrap">
                            <button @click="emit('editProject', project)"  type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Editar</button>
                        </td>
                        <td class="py-4 whitespace-nowrap">
                            <button @click="emit('pinnedProject', project.id)" type="button" class="ml-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-red active:bg-green-600 transition duration-150 ease-in-out">
                                {{ project.task_progress?.pinned_on_dashboard === 1 ? 'Fijado' : 'Fijar' }}
                            </button>
                        </td>
                        <td class="py-4 whitespace-nowrap">
                            <RouterLink :to="`/kaban?query=${project.slug}`" class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-500 focus:outline-none focus:shadow-outline-yellow active:bg-yellow-600 transition duration-150 ease-in-out">
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
}, 300);
</script>

<style scoped></style>