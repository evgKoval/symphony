export default function auth(to, from, next) {
    if(!localStorage.getItem('token')) {
        return next({
           name: 'login'
        })
    }
    return next()
}   