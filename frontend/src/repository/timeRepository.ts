import http from '@/plugins/http.js'

const timeRepository = {

  store: (data) => http.post('/api/time', data),
  index: (data) => http.get('/api/time', data),
  delete: (id) => http.delete(`/api/time/${id}`)
}
export default timeRepository
