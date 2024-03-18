import http from '@/plugins/http.js'

const projectRepository = {
  update: (id, data) => http.put(`/api/project/${id}`, data),
  store: (params) => http.post('/api/project', params),
  index: (params = {}) => http.get('/api/project', params),
  show: () => http.get('/api/project'),
  delete: (id) => http.delete(`/api/project/${id}`)
}
export default projectRepository
