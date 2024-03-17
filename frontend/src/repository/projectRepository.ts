
import http from '@/plugins/http.js'

const projectRepository = {
  update: (id,data) => {
    return http.put(`/api/project/${id}`,data)
  },
  store: (params) => {
    return http.post('/api/project',  params)
  },
  index: (params={}) => {
    return http.get('/api/project',params)
  },
  show: () => {
    return http.get('/api/project')
  },
  delete: (id) => {
    return http.delete(`/api/project/${id}`)
  }
}
export default projectRepository
