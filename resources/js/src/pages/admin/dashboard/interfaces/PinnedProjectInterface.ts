export interface IPinnedProject {
    id: string;
    name: string;
}

export interface IPinnedProjectResponse {
    message: string;
    data: IPinnedProject;
    code: number;
}