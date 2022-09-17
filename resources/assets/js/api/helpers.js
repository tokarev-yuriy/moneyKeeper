/**
 * Response error parsing
 */
 export const parseError = (response) => {

    if (response === undefined) {
        return {
            errors: ["CORS or network"],
            code: 504,
        }
    }

    const data = response.data
    const status = response.status || data.error.status
    let errors = (data.errors) || []

    if (!errors || errors.length == 0) {
        switch (status) {
            case 500:
                errors = ["Internal Server Error"]
                break
            case 400:
                errors = ["Bad Request"]
                break
            case 401:
                errors = ["Unauthorized"]
                break
            case 403:
                errors = ["Forbidden"]
                break
            default:
                errors = ["Unknown error"]
                break
        }
    }
    return {
        errors: errors,
        code: status,
    }
};