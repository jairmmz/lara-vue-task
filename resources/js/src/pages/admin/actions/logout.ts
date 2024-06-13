import { ref } from "vue";
import { makeHttpRequest } from "../../../helpers/makeHttpRequest";
import { showErrorResponse } from "../../../helpers/utils";
import { showSuccess } from "../../../helpers/toastNotification";
import { useUserStore } from "../../../store/user";

export function useLogoutUser() {
    const isLoading = ref(false);
    const { setToken, setUser } = useUserStore();

    async function logout(userId: string | undefined) {
        try {
            isLoading.value = true;
            const response = await makeHttpRequest<{ userId: string | undefined }, { message: string }>
            ('auth/logout', 'POST', { userId: userId });
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