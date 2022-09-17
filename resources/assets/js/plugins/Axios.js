import axios from "axios"

// create instance
const apiAxios = axios.create({
  withCredentials: false,
  headers: {
    common: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
  },
})

const initAxios = (app) => {
  app.prototype.$api = apiAxios
}

const setDefaultAxiosParam = (param, value) => {
  apiAxios.defaults.params = apiAxios.defaults.params || {}
  apiAxios.defaults.params[param] = value
}

const setDefaultAxiosHeader = (param, value) => {
  apiAxios.defaults.headers = apiAxios.defaults.headers || { common: {} }
  apiAxios.defaults.headers.common[param] = value
}

export { initAxios, setDefaultAxiosParam, setDefaultAxiosHeader, apiAxios as $api }