import http from '@/plugins/http.js'

const taskRepository = {
  update: (id, params) => http.put(`/api/task/${id}`, params),
  store: (params) => http.post('/api/task', params),
  index: (params = {}) => http.get('/api/task', params),
  show: () => http.get('/api/task'),
  delete: (id) => http.delete(`/api/task/${id}`)
}
export default taskRepository
