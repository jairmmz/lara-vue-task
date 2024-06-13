import { ref } from 'vue';
import { makeHttpRequest } from '../../../helpers/makeHttpRequest';
import { showError, showSuccess } from '../../../helpers/toastNotification';
import { IUserLogin, IUserLoginResponse } from '../../../interfaces/UserInterface';
import { useUserStore } from '../../../store/user';

export function useLoginUser() {
    const { setToken, setUser } = useUserStore();
    const isLoading = ref(false);

    async function login(user: IUserLogin) {
        try {
            isLoading.value = true;
            const request = await makeHttpRequest<IUserLogin, IUserLoginResponse>('auth/login', 'POST', user);
            isLoading.value = false;
            
            if (request.code === 200) {
                showSuccess(request.message);
                setUser(request.data.user);
                setToken(request.data.token);
                window.location.href = '/admin';
            }
        } catch (error: any) {
            isLoading.value = false;
            showError(error.data);
        }
    }

    return { login, isLoading };
}
