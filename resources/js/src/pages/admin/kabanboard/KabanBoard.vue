<template>
    <div class="container-fluid">
        <AddTaskModal :is-open-modal="isModalOpen" @refreshKabanBoard="refreshKabanBoard" @getMembers="getMembers" :members="memberData"
            @closeModal="closeTaskModal"/>

        <BreadCrumb />
        <ProjectData :projectData="projectData" />
        <ProjectProgress v-if="projectData.data?.task_progress.progress":projectData="projectData" />

        <div class="grid grid-cols-3 mt-4 gap-3">
            <NotStartedColumn @from-not-started-to-pending="fromNotStartedToPending" :projectData="projectData"
                @openTaskModal="openTaskModal" 
            />

            <PendingColumn @from-pending-to-completed="fromPendingToCompleted" :projectData="projectData" />

            <CompletedColumn @from-completed-to-pending="fromCompletedToPending" :projectData="projectData" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useGetProjectDetail } from './actions/getProjectDetail';
import { useGetMember } from '../member/actions/getMembers';
import { storeToRefs } from 'pinia';
import { taskStore } from './store/kaban';
import { useDragTask } from './actions/dragTask';
import { useSelectMember } from './actions/selectMember';
import { ITaskCreate } from './interfaces/TaskInterface';
import BreadCrumb from './components/BreadCrumb.vue';
import ProjectData from './components/ProjectData.vue';
import ProjectProgress from './components/ProjectProgress.vue';
import NotStartedColumn from './components/NotStartedColumn.vue';
import PendingColumn from './components/PendingColumn.vue';
import CompletedColumn from './components/CompletedColumn.vue';
import AddTaskModal from './components/AddTaskModal.vue';

const route = useRoute();
const slug = route.query?.query as string;
const isModalOpen = ref(false);

const { task } = storeToRefs(taskStore);

const { projectData, getProjectDetail } = useGetProjectDetail();
const { getMembers, memberData } = useGetMember();
const { clearSelectedMembers } = useSelectMember();
const { fromNotStartedToPending, fromPendingToCompleted, fromCompletedToPending } = useDragTask(getProjectDetail, slug);

const openTaskModal = async () => {
    isModalOpen.value = true;
    task.value.project_id = projectData.value.data.project.id;
    task.value.member_id = [];
}

const closeTaskModal = () => {
    isModalOpen.value = false;
    clearSelectedMembers();
    task.value = {} as ITaskCreate;
}

const refreshKabanBoard = async () => {
    await getProjectDetail(slug);
}

onMounted(async () => {
    await getProjectDetail(slug);
    await getMembers(1, '');
});
</script>

<style>
.hovered{
    border:2px dashed rgb(157, 156, 156);
    border-radius: 5px;
}
.assignees button {
    border-radius: 50px;
    width: 40px;
    height: 40px;
    border: 1px solid grey;
}
.assignees .member_1 {
    position: relative;
    left: -10px;
}
.assignees .member_2 {
    position: relative;
    left: -20px;
}
.task_card {
    padding: 10px;
    margin-top: 7px;
}
.not_started_task {
    background-color: aliceblue;
}
.pending_task {
    background-color: rgb(232, 233, 233);
}
</style>