import Vue          from "vue";
import VueRouter    from "vue-router";
import store        from "@js/store/index";

Vue.use(VueRouter);

//Views
import DashboardView            from "@js/views/main/dashboard";
import HistoryView            from "@js/views/main/history";
import UploadView               from "@js/views/main/upload";
import UserSettingsView         from "@js/views/user/settings";
import AdminView                from "@js/views/admin/index";
import AdminDashboard           from "@js/views/admin/dashboard";
import AdminUsers               from "@js/views/admin/users";
import AdminRoles               from "@js/views/admin/roles";
import AdminRolesList           from "@js/views/admin/roles/list";
import AdminRolesEdit           from "@js/views/admin/roles/edit";
import AdminPackages            from "@js/views/admin/packages";

//Routes
const routes = [
    {
        name: 'dashboard',
        path: '/',
        component: DashboardView
    },
    {
        name: 'history',
        path: '/history',
        component: HistoryView
    },
    {
        name: 'popular',
        path: '/popular',
        component: DashboardView
    },
    {
        name: 'upload',
        path: '/upload',
        component: UploadView,
        meta: { requiresAuth: true }
    },
    {
        name: 'profile',
        path: '/profile',
        component: UserSettingsView,
        meta: { requiresAuth: true }
    },
    {
        name: 'admin',
        path: '/admin',
        component: AdminView,
        meta: { requiresAuth: true },
        children: [
            {
                name: 'admin-dashboard',
                path: 'dashboard',
                component: AdminDashboard
            },
            {
                name: 'admin-users',
                path: 'users',
                component: AdminUsers
            },
            {
                name: 'admin-roles',
                path: 'roles',
                component: AdminRoles,
                children: [
                    {
                        name: 'admin-roles-list',
                        path: 'list',
                        component: AdminRolesList
                    },
                    {
                        name: 'admin-roles-edit',
                        path: 'edit/:roleId',
                        component: AdminRolesEdit,
                        props: ({params}) => ({roleId: Number.parseInt(params.roleId, 10) || null})
                    }
                ]
            },
            {
                name: 'admin-packages',
                path: 'packages',
                component: AdminPackages
            }
        ]
    },
    {
        name: 'artist',
        path: '/artist',
        component: DashboardView
    },
    {
        name: 'search',
        path: '/search',
        component: DashboardView
    }
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

//Authentication check
router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if(store.getters.hasToken) {
            next()
            return
        }
        next('/')
    } else {
        next()
    }
});

export default router;
