import Vue from 'vue'
import Router from 'vue-router'
import store from "@/store/store";
import Home from "@/Views/Home";
import SignInComponent from "@/components/AuthorizationComponents/SignInComponent";
import SignUpComponent from "@/components/AuthorizationComponents/SignUpComponent";
import FileViewerComponent from "@/components/FileManagerComponents/FileViewerComponent";

Vue.use(Router);

let router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/login',
            name: 'login',
            component: SignInComponent
        },
        {
            path: '/register',
            name: 'register',
            component: SignUpComponent
        },
        {
            path: '/files/:name',
            name: 'file',
            component: FileViewerComponent,
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next();
            return;
        }
        next('/login');
    } else {
        next();
    }
});

export default router;