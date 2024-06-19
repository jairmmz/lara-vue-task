import { ref } from "vue";
import { IGetProjects } from "../interfaces/ProjectInterface";
import { makeHttpRequest } from "../../../../helpers/makeHttpRequest";
import { showErrorResponse } from "../../../../helpers/utils";

export function useGetProject() {
    const isLoading = ref(false);
    const projectData = ref<IGetProjects>();

    async function getProjects(page : number = 1, query : string = '') {
        try {
            isLoading.value = true;
            const response = await makeHttpRequest<undefined, IGetProjects>
            (`project?query=${query}&page=${page}`, 'GET'); 
            isLoading.value = false;
            projectData.value = response;
        } catch (error) {
            isLoading.value = false;
            showErrorResponse(error);
        }
    }

    return { getProjects, isLoading, projectData };
}