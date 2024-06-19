import { ref } from "vue";
import { makeHttpRequest } from "../../../../helpers/makeHttpRequest";
import { ITaskCreate } from "../interfaces/TaskInterface";
import { storeToRefs } from "pinia";
import { taskStore } from "../store/kaban";
import { showSuccess } from "../../../../helpers/toastNotification";
import { showErrorResponse } from "../../../../helpers/utils";

export function useCreateTask() {
    const isLoading = ref(false);
    const { task } = storeToRefs(taskStore);

    async function createTask() {
        try {
            isLoading.value = true;
            const response = await makeHttpRequest<ITaskCreate, { message: string }>
            ('task/save', 'POST', task.value);

            isLoading.value = false;
            showSuccess(response.message);
        } catch (error) {
            isLoading.value = false;
            showErrorResponse(error);
        }
    }

    return { createTask, isLoading };
}