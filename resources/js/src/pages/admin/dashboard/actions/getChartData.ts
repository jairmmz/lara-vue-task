import { ref } from "vue";
import { makeHttpRequest } from "../../../../helpers/makeHttpRequest";
import { showErrorResponse } from "../../../../helpers/utils";

export interface IChartData {
    message: string;
    data: {
        tasks: number[];
        progress: number;
    } | null;
    code: number;
}

export function userGetChartData() {
    const chartData = ref<IChartData>({} as IChartData);

    async function getChartData(projectId: string) {
        try {
            const data = await makeHttpRequest<undefined, IChartData>
            (`project/chart-data-proyects?project_id=${projectId}`, 'GET');

            chartData.value = data;
            updateData();
        } catch (error) {
            showErrorResponse(error);
        }
    }

    function updateData() {
        // window.Echo.channel('projectProgress')
        // .listen('TrackProjectProgress', (event: { projectProgress: number }) => {
        //     if (!chartData.value.data) return;
        //     chartData.value.data.progress = 0;
            
        //     chartData.value.data.progress = event.projectProgress;
        //     setTimeout(() => {
        //         chartData.value.data?.progress = event.projectProgress;
        //     }, 1000);
        // });

        // window.Echo.channel('tasks')
        // .listen('TrackCompletedAndPendingTask', (event: { tasks: number[] }) => {
        //     if (!chartData.value.data) return;
        //     console.log(event);
            
        //     chartData.value.data.tasks = undefined as any;
        //     setTimeout(() => {
        //         chartData.value.data.tasks = event.tasks;
        //     }, 2000);

        //     console.log(event);
        // });
    }

    return { getChartData, chartData };
}