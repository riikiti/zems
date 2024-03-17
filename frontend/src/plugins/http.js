import axios from 'axios'
import { stringify } from 'qs'
import {useAuth} from "@/stores/auth";

const http = axios.create({
    baseURL: 'http://127.0.0.1:8000',
    paramsSerializer: params => stringify(params)
})
/*http.CancelToken = axios.CancelToken*/

http.interceptors.request.use(
    function (config) {
        const token = localStorage.getItem('JWT_SECRET')
        config.headers = {
            ...config.headers,
            ...(token && { Authorization: `Bearer ${token}` })
        }
        return config
    },
    function (error) {
        return Promise.reject(error)
    }
)


export default http