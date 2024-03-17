
import http from '@/plugins/http.js'

const personalRepository = {
  login: (params) => {
    return http.post('/api/auth/login', params)
  },
  register: (params) => {
    return http.post('/api/auth/register', params)
  },
  refresh: () => {
    return http.post('/api/auth/refresh')
  },
  profile: () => {
    return http.post('/api/auth/me')
  }
}
export default personalRepository
