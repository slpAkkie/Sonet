import middlewarePipeline from './middlewarePipeline'
import store from '../store'

export default function beforeGuard(to, from, next) {
    const middleware = to.meta['middleware']

    if (!middleware) return next()

    const context = {
        to,
        from,
        next,
        store,
    }

    return middleware[0]({
        ...context,
        nextInPipeline: middlewarePipeline(context, middleware, 1)
    })
}