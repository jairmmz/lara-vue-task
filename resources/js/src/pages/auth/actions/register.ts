import { ref } from 'vue';
import { makeHttpRequest } from '../../../helpers/makeHttpRequest';
import { showError, showSuccess } from '../../../helpers/toastNotification';
import { IUserRegister, IUserRegisterResponse } from '../../../interfaces/UserInterface';

export function useRegisterUser() {
    const isLoading = ref(false);

    async function register(user: IUserRegister) {
        try {
            isLoading.value = true;
            const request = await makeHttpRequest<IUserRegister, IUserRegisterResponse>('auth/register', 'POST', user);
            isLoading.value = false;
            showSuccess(request.message);
        } catch (error: any) {
            isLoading.value = false;
            if (typeof error.data === 'string') {
                showError(error.message);
                return;
            }
            
            const messages = error.data;
            for (const key in messages) {
                if (messages.hasOwnProperty(key)) {
                    const fieldMessages = messages[key];
                    fieldMessages.forEach((message: string) => {
                        showError(message);
                    });
                }
            }
        }
    }

    return { register, isLoading };
}
