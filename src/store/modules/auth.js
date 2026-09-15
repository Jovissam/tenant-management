import { api } from '@/api'
let timer;
// console.log(timer);

export default {
    state() {
        return {
            token: null,
            userId: null,
            autoLogout: false
        }
    },
    mutations: {
        setUser(state, payload) {
            state.token = payload.token
            state.userId = payload.user
        },
        setAutoLogout(state){
            state.autoLogout = true;
        }
    },
    actions: {
        async auth(context, payload) {
            const res = await api(payload.url, {
                method: "POST",
                body: payload.body
            })
            if (!res.ok) {
                const errorData = await res.json()
                throw new Error(errorData.message || (payload.action == "register" ? "failed to register you" : "failed to login"));

            }
            const response = await res.json()

            const token = response.data?.token
            const userId = response.data?.userId
            const tokenExpiry = +response.data?.tokenExpiry

            localStorage.setItem('token', token)
            localStorage.setItem('userId', userId)
            localStorage.setItem('tokenExpiry', tokenExpiry)


            timer = setTimeout(function () {
                context.dispatch('autoLogout')
            }, tokenExpiry);

            context.commit('setUser', {
                token: token,
                user: userId,
            })
            return response;
        },
        async register(context, payload) {
            await context.dispatch('auth', {
                url: '/auth/register',
                body: JSON.stringify(payload),
                action: "register"
            })
        },
        async login(context, payload) {
            return await context.dispatch('auth', {
                url: '/auth/login',
                body: JSON.stringify(payload),
                action: "login"
            })
        },
        tryLogin(context) {
            const token = localStorage.getItem('token') || null;
            const userId = localStorage.getItem('userId') || null;
            const tokenExpiry = localStorage.getItem('tokenExpiry') || null;

            const expiresIn = +tokenExpiry - new Date().getTime();
            if (expiresIn <= 0) {
                return
            }
            timer = setTimeout(() => {
                context.dispatch('autoLogout')
            }, tokenExpiry);
            if (userId && token) {
                context.commit('setUser', {
                token: token,
                user: userId,
            })
            }

        },
        autoLogout(context){
          context.dispatch('logout')
          context.commit('setAutoLogout')  
        },
        logout(context) {
            localStorage.removeItem('token')
            localStorage.removeItem('userId')
            localStorage.removeItem('tokenExpiry')

            clearTimeout(timer)

            context.commit('setUser', {
                token: null,
                user: null,
            })
        },
    },
    getters: {
    }
}