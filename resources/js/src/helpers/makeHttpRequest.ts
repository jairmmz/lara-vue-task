import { useUserStore } from "../store/user";
import { APP } from "../variables";
import { getUserData } from "./getUserData";

type HttpVerbType = "GET" | "POST" | "PUT" | "DELETE";

export function makeHttpRequest<TInput, TResponse>(
    endpoint: string,
    verb: HttpVerbType,
    input?: TInput
) {
    return new Promise<TResponse>(async (resolve, reject) => {
        try {
            const { token } = useUserStore(); 
            const response = await fetch(`${APP.API_BASE_URL}/${endpoint}`, {
                method: verb,
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(input),
            });

            const data: TResponse = await response.json();

            if (!response.ok) {
                reject(data);
            }

            resolve(data);
        } catch (error) {
            reject(error);
        }
    });
}
