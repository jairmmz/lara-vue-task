import { defineStore } from 'pinia';
import { IProject } from '../interfaces/ProjectInterface';

const useProjectStore = defineStore('project', {
    state: () => ({
        project: {} as IProject,
        isEdit: false as boolean,
    }),
    getters: {
        
    },
    actions: {
        
    },
});

export const projectStore = useProjectStore();

