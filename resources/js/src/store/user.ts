import { defineStore } from 'pinia';
import { IUser } from '../interfaces/UserInterface';

export const useUserStore = defineStore('user', {
    state: () => ({
        user: { } as IUser,
        token: null as string | null,
    }),
    
    getters: { },

    actions: {
        setUser(user: IUser) {
            this.user = user;
        },

        setToken(token: string | null) {
            this.token = token;
        }
    },

    persist: [
        {
            paths: ['user', 'token'],
            storage: localStorage,
        }
    ]
});
