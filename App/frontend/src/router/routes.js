import auth from './middleware/auth'

export default [
    {
        path: '/',
        name: 'Landing',
        component: () => import('../views/Landing'),
        meta: {
            layout: 'Auth',
        },
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../views/Login'),
        meta: {
            layout: 'Auth',
        },
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('../views/Register'),
        meta: {
            layout: 'Auth',
        },
    },
    {
        path: '/home',
        name: 'Home',
        component: () => import('../views/Home'),
        meta: {
            middleware: [ auth ],
            layout: 'Home',
        },
    },
    {
        path: '/notes/:id',
        name: 'NoteView',
        component: () => import('../views/NoteView'),
        props: true,
        meta: {
            middleware: [ auth ],
            layout: 'Home',
        },
    },
]
