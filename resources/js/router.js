import Vue from "vue";
import Router from "vue-router";



import category from "./components/dashboard/category/Home.vue"
import categorylist from "./components/dashboard/category/CategoryList.vue"


import blog from "./components/dashboard/Blog/Home.vue"
import bloglist from "./components/dashboard/Blog/BlogList.vue"
import blogreply from "./components/dashboard/Blog/BlogReply.vue"

import setting from "./components/dashboard/setting/Home.vue"
import profile from "./components/dashboard/setting/Profile.vue"



let onlyAdmin = [1];

Vue.use(Router);
export default new Router({
    mode: "history",
    routes: [
      
        {
            path: "/category",
            name: "category",
            component: category,
            meta: {
                icon: "supervisor_account",
                title: " Category",
                type: onlyAdmin,
                status: true
            },
            children: [
                {
                    path: "categorylist",
                    name: "categorylist",
                    component: categorylist,
                    meta: {
                        icon: "class",
                        title: "Category List",
                        type: onlyAdmin,
                        status: true
                    }
                },
            ]
        },
        {
            path: "/blog",
            name: "blog",
            component: blog,
            meta: {
                icon: "supervisor_account",
                title: " Project",
                type: onlyAdmin,
                status: true
            },
            children: [
                {
                    path: "bloglist",
                    name: "bloglist",
                    component: bloglist,
                    meta: {
                        icon: "class",
                        title: "Blog List",
                        type: onlyAdmin,
                        status: true
                    }
                },
                {
                    path: "blogreply",
                    name: "blogreply",
                    component: blogreply,
                    meta: {
                        icon: "class",
                        title: "Blog Reply",
                        type: onlyAdmin,
                        status: true
                    }
                },
            ]
        },
        {
            path: "/setting",
            name: "setting",
            component: setting,
            meta: {
                icon: "settings",
                title: "Setting",
                type: onlyAdmin,
                status: true
            },
            children: [
                {
                    path: "profile",
                    name: "profile",
                    component: profile,
                    meta: {
                        icon: "dashboard",
                        title: "Profile",
                        type: onlyAdmin,
                        status: true
                    }
                },
            
            ]
        }
    ]
});

