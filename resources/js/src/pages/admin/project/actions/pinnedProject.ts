import { ref } from "vue";
import { makeHttpRequest } from "../../../../helpers/makeHttpRequest";
import { showSuccess } from "../../../../helpers/toastNotification";
import { showErrorResponse } from "../../../../helpers/utils";

export function usePinnedProject() {
    const isLoading = ref(false);

    async function pinnedProject(projectId: string) {
        try {
            isLoading.value = true;
            const response = await makeHttpRequest<{ projectId: string}, { message: string }>
            ('project/pinned', 'POST', { projectId: projectId });
            isLoading.value = false;
            showSuccess(response.message);
        } catch (error) {
            isLoading.value = false;
            showErrorResponse(error);
        }
    }

    return { pinnedProject };
}