import { $api } from "../plugins/Axios"
import endpoints from "./endpoints"
import { parseError } from "./helpers"

/**
 * log in
 */
export const loginService = async (request) => {
    try {
        let response = await $api.post(endpoints.auth.login, {...request});
        if (response.data.success == true) {
            return true;
        }
        throw parseError(response);
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Register
 */
 export const registerService = async (request) => {
    try {
        let response = await $api.post(endpoints.auth.register, { ...request});
        if (response.data.success == true) {
            return true;
        }
        throw parseError(response);
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * log out
 */
 export const logoutService = async () => {
    try {
        let response = await $api.get(endpoints.auth.logout);
        if (response.data.success == true) {
            return true;
        }
        throw parseError(response);
    } catch(error) {
        throw parseError(error.response);
    }
}