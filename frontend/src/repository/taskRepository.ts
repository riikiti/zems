
import http from '@/plugins/http.js'

const taskRepository = {
  update: (id,params) => {
    return http.put(`/api/task/${id}`, params)
  },
  store: (params) => {
    return http.post('/api/task', params)
  },
  index: (params={}) => {
    return http.get('/api/task',params)
  },
  show: () => {
    return http.get('/api/task')
  },
  delete: (id) => {
    return http.delete(`/api/task/${id}`)
  }
}
export default taskRepository
