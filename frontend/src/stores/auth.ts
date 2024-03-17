import {defineStore} from 'pinia'
import personalRepository from "@/repository/personalRepository";

 export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuth: false,
        authTokenKey: 'JWT_SECRET',
        user: null,
    }),
    actions: {
        async fetchUser() {
            try {
                const response = await personalRepository.profile()
                const {data} = response
                this.user = data
                if(this.user){
                    this.isAuth=true
                }
            }
            catch (e) {
                console.log(e)
            }
        },
        async refresh() {
            try {
                console.log("123")
                const response = await personalRepository.refresh()
                const {data} = response
                const newToken = data.original.access_token
                localStorage.setItem(this.authTokenKey, newToken)
                this.isAuth = true
            } catch (e) {
                console.log(e)
            }
        },
        async login(params) {
            const response = await personalRepository.login(params)
            const {data} = response
            console.log(data)
            const newToken = data.access_token
            localStorage.setItem(this.authTokenKey, newToken)
            this.isAuth = true
            await this.fetchUser();

        },
        logout() {
            this.removeToken()
        },
        removeToken() {
            localStorage.removeItem(this.authTokenKey)
            localStorage.removeItem('auth')
            this.isAuth = false
            this.user=null
        },
        async register(params) {
            const response = await personalRepository.register(params)
            const {data} = response
            console.log(data)
            const newToken = data.token.original.access_token
            localStorage.setItem(this.authTokenKey, newToken)
            this.isAuth = true
        }
    },
    getters:{
        isLoginIn(state) {
            return state.isAuth
        }
    },
    persist: true,
})

/*Делаем стор доступным глобально вне setup*/
export function useAuth(){
     return useAuthStore()
}