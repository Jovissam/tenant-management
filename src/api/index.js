// import store from '@/store'
export async function api(url, options = {}) {
    const baseUrl = 'http://127.0.0.1:8000'
    const fullUrl = baseUrl + url
    const rawToken = localStorage.getItem('token');// store.state.auth.accessToken
    const token = (rawToken && rawToken !== 'null' && rawToken !== 'undefined') ? rawToken : null;


    const response = await fetch(fullUrl, {
        ...options,
        headers: {
            "Content-Type": "application/json",
            ...options.headers,

            ...(token ? { Authorization: `Bearer ${token}` } : {})
        }
    })
    if (response.status === 401) {
        // Token expired/invalid
        // Handle refresh or logout
        // store.dispatch("auth/logout")
    }

    return response;

}