<template>
    <div class="container w-full">
        <h1 class="text-3xl font-bold mb-4">Dashbaord</h1>
        <div class="mb-4">
            <div class="col-md-8">
                <h2 class="text-2xl font-bold inline">
                    Projecto:
                </h2>
                <span class="text-xl">{{ project?.name }}</span>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div class="">
                <div class="border-2 rounded-sm border-slate-400">
                    <div class="text-center py-2 bg-slate-300 border-b-2 border-slate-400">
                        <b>Total de Projectos</b>
                    </div>
                    <div class="card-body">
                        <h2 align="center">{{ countProject.data }}</h2>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="border-2 rounded-sm border-slate-400">
                    <div class="text-center py-2 bg-slate-300 border-b-2 border-slate-400"><b>Tareas</b></div>
                    <div class="card-body">
                        <div v-if="chartData.data?.tasks">
                            <ApexDonut :task="chartData.data.tasks" />
                        </div>
                        <div v-else>
                            <ApexDonut :task="[0, 0]" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="border-2 rounded-sm border-slate-400">
                    <div class="text-center py-2 bg-slate-300 border-b-2 border-slate-400">
                        <b>Task Progress</b>
                    </div>
                    <div class="card-body">
                        <div v-if="typeof chartData.data?.progress === 'number'">
                            <ApexRadialBar :percent="chartData.data?.progress" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useGetPinnedProject } from './actions/getPinnedProject';
import { useGetTotalProject } from './actions/countProject';
import { userGetChartData } from './actions/getChartData';
import ApexDonut from './components/ApexDonut.vue';
import ApexRadialBar from './components/ApexRadialBar.vue';

const { project, getPinnedProject } = useGetPinnedProject();
const { countProject, getTotalProject } = useGetTotalProject();
const { chartData, getChartData } = userGetChartData();


onMounted(async () => {
    await getPinnedProject();
    getChartData(project.value.id);
    getTotalProject();
});
</script>

<style scoped></style>