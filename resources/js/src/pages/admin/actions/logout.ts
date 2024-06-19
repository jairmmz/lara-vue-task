import { ref } from 'vue';
import { makeHttpRequest } from '../../../helpers/makeHttpRequest';
import { showErrorResponse } from '../../../helpers/utils';
import { showSuccess } from '../../../helpers/toastNotification';

export function useLogoutUser() {
    const isLoading = ref(false);

    async function logout() {
        try {
            isLoading.value = true;
            const response = await makeHttpRequest<undefined, { message: string }>
            ('auth/logout', 'POST');
            isLoading.value = false;
            showSuccess(response.message);
        } catch (error) {
            console.log((error as Error).message);
            showErrorResponse(error);

            if ((error as Error).message == 'No está autenticado') {
                window.location.href = '/login';
            }
            isLoading.value = false;
        }
    }

    return { isLoading, logout }
}