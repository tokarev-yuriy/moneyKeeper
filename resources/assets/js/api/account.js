import { $api } from "../plugins/Axios"
import endpoints from "./endpoints"
import { parseError } from "./helpers"

/**
 * List of accounts
 */
export const accountListService = async () => {
    try {
        let response = await $api.get(endpoints.account.index);
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Account detail
 */
 export const accountDetailService = async (id) => {
    try {
        let response = await $api.get(endpoints.account.detail.replace("{id}", id));
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Account update
 */
 export const accountUpdateService = async (id, request) => {
    try {
        let response = await $api.put(endpoints.account.detail.replace("{id}", id), {...request});
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Account add
 */
 export const accountAddService = async (request) => {
    try {
        let response = await $api.post(endpoints.account.index, {...request});
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Account delete
 */
 export const accountDeleteService = async (id) => {
    try {
        let response = await $api.delete(endpoints.account.detail.replace("{id}", id));
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}