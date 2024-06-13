import { ref } from "vue";
import { showErrorResponse } from "../../../../helpers/utils";
import { makeHttpRequest } from "../../../../helpers/makeHttpRequest";
import { IProject, IProjectResponse } from "../interfaces/ProjectInterface";
import { storeToRefs } from "pinia";
import { projectStore } from "../store/projectStore";
import { showSuccess } from "../../../../helpers/toastNotification";

const { project, isEdit } = storeToRefs(projectStore);

export function useCreateOrUpdateProject() {
    const isLoading = ref(false);

    async function createOrUpdate() {
        try {
            isLoading.value = true;
            const response = isEdit.value ? await update() : await create();
            isLoading.value = false;
            showSuccess(response.message);
        } catch (error) {
            isLoading.value = false;
            showErrorResponse(error);           
        }
    }

    return { createOrUpdate, isLoading };
}

async function create() {
    const data = await makeHttpRequest<IProject, IProjectResponse>
    ('project/save', 'POST', project.value);

    return data;
}

async function update() {
    const data = await makeHttpRequest<IProject, IProjectResponse>
    (`project/update/${project.value.id}`, 'PUT', project.value);

    isEdit.value = false;

    return data;
}
