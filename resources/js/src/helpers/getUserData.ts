import { IUser } from '../interfaces/UserInterface';
import { useUserStore } from '../store/user';

export function getUserData(): IUser | undefined {
    const { user } = useUserStore();
    try {
        if (user) { 
            return user;
        }
    } catch (error) {
        console.log((error as Error).message);
    }
}