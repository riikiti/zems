import http from '@/plugins/http.js'

const personalRepository = {
  login: (params) => http.post('/api/auth/login', params),
  register: (params) => http.post('/api/auth/register', params),
  refresh: () => http.post('/api/auth/refresh'),
  profile: () => http.post('/api/auth/me')
}
export default personalRepository
