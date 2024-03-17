
import http from '@/plugins/http.js'

const timeRepository = {

  store: (data) => {
    return http.post('/api/time', data)
  },
  index: (data) => {
    return http.get('/api/time',data)
  },
  delete: (id) => {
    return http.delete(`/api/time/${id}`)
  }
}
export default timeRepository
