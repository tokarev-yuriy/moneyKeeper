import { $api } from "../plugins/Axios"
import endpoints from "./endpoints"
import { parseError } from "./helpers"

/**
 * List of account groups
 */
export const accountGroupListService = async () => {
    try {
        let response = await $api.get(endpoints.accountGroup.index);
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Account group detail
 */
 export const accountGroupDetailService = async (id) => {
    try {
        let response = await $api.get(endpoints.accountGroup.detail.replace("{id}", id));
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Account group update
 */
 export const accountGroupUpdateService = async (id, request) => {
    try {
        let response = await $api.put(endpoints.accountGroup.detail.replace("{id}", id), {...request});
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Account group add
 */
 export const accountGroupAddService = async (request) => {
    try {
        let response = await $api.post(endpoints.accountGroup.index, {...request});
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}

/**
 * Account group delete
 */
 export const accountGroupDeleteService = async (id) => {
    try {
        let response = await $api.delete(endpoints.accountGroup.detail.replace("{id}", id));
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}