export default function auth({next, store, nextInPipeline}) {
    if (!store.getters.isAuthorized) {
        return next({ name: 'Login' })
    }

    store.dispatch('verifyToken')

    return nextInPipeline()
}