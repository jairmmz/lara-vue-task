export interface IUser {
    id: string;
    email: string;
    isValidEmail: number;
}

export interface IUserRegister {
    email: string;
    password: string;
    password_confirmation: string;
}

export interface IUserRegisterResponse {
    message: string;
    data: IUser;
    code: number;
};

export interface IUserLogin {
    email: string;
    password: string;
}

export interface IUserLoginResponse {
    message: string;
    data: {
        user: IUser;
        token: string;
    };
    code: number;
}