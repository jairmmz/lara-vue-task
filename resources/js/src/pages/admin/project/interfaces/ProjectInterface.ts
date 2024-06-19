export interface IProject {
    id: string;
    name: string;
    start_date: string;
    end_date: string;
    slug?: string;
    task_progress?: ItaskProgress;
}

export interface IProjectResponse {
    message: string;
    data: IProject;
}

export interface IGetProjects {
    data: {
        data: IProject[]
    }
}

export interface ItaskProgress {
    id: string;
    project_id: string;
    pinned_on_dashboard: number;
    progress: string;
}