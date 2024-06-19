<template>
    <div class="block pending-task rounded-lg bg-slate-50 p-6 text-surface shadow-secondary-1 dark:bg-surface-dark">
        <div class="bg-slate-400 text-center w-full mb-2 text-white font-bold py-2 px-4 rounded">
            Pendiente
        </div>

        <div v-for="task in projectData.data?.tasks" :key="task.id" 
            class="rounded-md p-2 bg-slate-100 m-2"
            v-show="task.status === TaskStatus.PENDING"
            @drag="emit('fromPendingToCompleted', task.id, projectData.data?.project.id)"
            draggable="true" :class="`task-card pending-task-${task.id}`">
            
            <p class="mb-4 font-bold text-sm">{{ task.name }}</p>

            <div class="flex -space-x-2 items-center">
                <button v-for="(member, index) in task.task_members" :key="member.id" 
                    :class="`z-40 inline-block border border-cyan-500 h-10 w-10 rounded-full ring-2 ring-white ring-opacity-50 ${index}`">
                    {{ getChar(member.member.name) }}
                </button>
                <span class="pl-3 text-md">{{ task.task_members.length }} asignados.</span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { getChar, myDebounce } from '../../../../helpers/utils';
import { ISingleProjectResponse, TaskStatus } from '../interfaces/ProjectDetailInterface';


defineProps<{
    projectData: ISingleProjectResponse;
}>();

const emit = defineEmits<{
    (event: 'fromPendingToCompleted', taskId: string, projectId: string): Promise<void>;
}>();
</script>

<style scoped></style>