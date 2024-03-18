import axios from 'axios'
import { stringify } from 'qs'

const http = axios.create({
  baseURL: 'http://127.0.0.1:8000',
  paramsSerializer: (params) => stringify(params)
})

http.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('JWT_SECRET')
    config.headers = {
      ...config.headers,
      ...(token && { Authorization: `Bearer ${token}` })
    }
    return config
  },
  (error) => Promise.reject(error)
)

export default http
