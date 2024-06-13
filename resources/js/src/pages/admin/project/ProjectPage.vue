<template>
    <div class="flex justify-between items-center">
        <h1 class="mb-4 font-bold text-xl">Gestión de Proyectos</h1>
        <RouterLink :to="{ name: 'create.project' }"
            class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
            Crear proyecto
        </RouterLink>
    </div>
    <ProjectTable @edit-project="editProject" :is-loading="isLoading" @get-projects="getProjects" :projects="projectData" @pinned-project="pinnedProjectOnDashboard">
        <template #pagination>
            <TailwindPagination v-if="projectData?.data" :data="projectData?.data" @pagination-change-page="getProjects" />
        </template>
    </ProjectTable>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useGetProject } from './actions/getProjects';
import { TailwindPagination } from 'laravel-vue-pagination';
import { IProject } from './interfaces/ProjectInterface';
import { storeToRefs } from 'pinia';
import { projectStore } from './store/projectStore';
import { usePinnedProject } from './actions/pinnedProject';
import ProjectTable from './components/ProjectTable.vue';

const router = useRouter();

const { getProjects, isLoading, projectData } = useGetProject();
const { pinnedProject } = usePinnedProject();
const { project, isEdit } = storeToRefs(projectStore);

const showListProjects = async () => {
    await getProjects();
}

const editProject = (projectEdit: IProject) => {
    project.value = {
        id: projectEdit.id,
        name: projectEdit.name,
        start_date: projectEdit.start_date,
        end_date: projectEdit.end_date
    }
    isEdit.value = true;
    router.push({ name: 'edit.project', params: { id: projectEdit.id } });
}

const pinnedProjectOnDashboard = async (projectId: string) => {
    await pinnedProject(projectId);
    router.push({ name: 'admin' });
}

onMounted(async () => {
    showListProjects();
    isEdit.value = false;
    project.value = {} as IProject;
})
</script>

<style scoped>

</style>