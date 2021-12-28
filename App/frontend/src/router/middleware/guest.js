export default function guest({next, store, nextInPipeline}) {
    if (store.getters.isAuthorized) {
        return next({ name: 'Home' })
    }

    return nextInPipeline()
}