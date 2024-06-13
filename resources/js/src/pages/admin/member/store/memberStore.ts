import { defineStore } from 'pinia';
import { IMember, IMemberCreate, IMemberUpdate } from '../interfaces/MemberInterface';

const useMemberStore = defineStore('member', {
    state: () => ({
        member: {} as IMember,
        isEdit: false,
    }),
    getters: {
        
    },
    actions: {
        
    },
});

export const memberStore = useMemberStore();