import { defineStore } from 'pinia';
import { ITaskCreate } from '../interfaces/TaskInterface';

const useTaskStore = defineStore('task', {
    state: () => ({
        task: {} as ITaskCreate,
        isEdit: false,
        currentTaskId: '' as string,
    }),

    getters: { },
    
    actions: { },
});

export const taskStore = useTaskStore();