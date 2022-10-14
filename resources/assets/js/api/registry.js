import { $api } from "../plugins/Axios"
import endpoints from "./endpoints"
import { parseError } from "./helpers"

/**
 * get registry
 */
export const getRegistryService = async () => {
    try {
        let response = await $api.get(endpoints.registry);
        if (response.data.success == true) {
            return response.data;
        }
        throw {response: response};
    } catch(error) {
        throw parseError(error.response);
    }
}