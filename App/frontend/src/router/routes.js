import auth from './middleware/auth'

export default [
    {
        path: '/',
        name: 'Landing',
        component: () => import('../views/Landing'),
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
        path: '/login',
        name: 'Login',
        component: () => import('../views/Login'),
        meta: {
            layout: 'Auth',
        },
    },
    {
        path: '/logout',
        name: 'Logout',
        component: () => import('../views/Logout'),
        meta: {
            layout: 'Auth',
        },
    },
    {
        path: '/settings',
        name: 'UserSettings',
        component: () => import('../views/UserSettings'),
        meta: {
            layout: 'Authorized',
            middleware: [ auth ]
        },
    },
    {
        path: '/home',
        name: 'Home',
        component: () => import('../views/notes/Index'),
        meta: {
            middleware: [ auth ],
            layout: 'NotesIndex',
        },
    },
    {
        path: '/home/folder/:folder_id',
        name: 'IndexFolderNotes',
        component: () => import('../views/notes/Index'),
        props: true,
        meta: {
            middleware: [ auth ],
            layout: 'NotesIndex',
        },
    },
    {
        path: '/home/without-folder',
        name: 'IndexNotesWithoutFolder',
        component: () => import('../views/notes/Index'),
        meta: {
            middleware: [ auth ],
            layout: 'NotesIndex',
        },
    },
    {
        path: '/home/shared',
        name: 'IndexSharedNotes',
        component: () => import('../views/notes/Index'),
        meta: {
            middleware: [ auth ],
            layout: 'NotesIndex',
        },
    },
    {
        path: '/notes/create',
        name: 'CreateNote',
        component: () => import('../views/notes/Create'),
        meta: {
            middleware: [ auth ],
            layout: 'Authorized',
        },
    },
    {
        path: '/notes/:id',
        name: 'ViewNote',
        component: () => import('../views/notes/View'),
        props: true,
        meta: {
            middleware: [ auth ],
            layout: 'Authorized',
        },
    },
]
