import Vue from "vue";
import Router from "vue-router";

import overview from "./components/dashboard/overview/overview.vue";

import user from "./components/dashboard/user/Home.vue"
import userlist from "./components/dashboard/user/UserList.vue"
import rolelist from "./components/dashboard/user/RoleList.vue"


import category from "./components/dashboard/category/Home.vue"
import categorylist from "./components/dashboard/category/CategoryList.vue"

import services from "./components/dashboard/services/Home.vue"
import serviceslist from "./components/dashboard/services/ServicesList.vue"
import servicesadd from "./components/dashboard/services/ServicesAdd.vue"
import servicesedit from "./components/dashboard/services/ServicesEdit.vue"

import blogproject from "./components/dashboard/blogproject/Home.vue"
import bloglist from "./components/dashboard/blogproject/BlogList.vue"
import projectlist from "./components/dashboard/blogproject/ProjectList.vue"

import setting from "./components/dashboard/setting/Home.vue"
import profile from "./components/dashboard/setting/Profile.vue"
import aboutus from "./components/dashboard/setting/AboutUs.vue"
import bannerlist from "./components/dashboard/setting/Banner.vue"
import ourcustomer from "./components/dashboard/setting/OurCustomer.vue"
import contactus from "./components/dashboard/setting/ContactUs.vue"
import social from "./components/dashboard/setting/Social.vue"
import ourteam from "./components/dashboard/setting/OurTeam.vue"



let onlyAdmin = [1];

Vue.use(Router);
export default new Router({
    mode: "history",
    routes: [
        {
            path: "/home",
            name: "home",
            component: overview,
            meta: {
                icon: "dashboard",
                title: "Dashboard",
                type: onlyAdmin,
                status: true
            },
            children: [
                {
                    path: "overview",
                    name: "overview",
                    component: overview,
                    meta: {
                        icon: "dashboard",
                        title: "Overview",
                        type: onlyAdmin,
                        status: true
                    }
                }
            ]
        },
        // {
        //     path: "/user",
        //     name: "user",
        //     component: user,
        //     meta: {
        //         icon: "supervisor_account",
        //         title: "User",
        //         type: onlyAdmin,
        //         status: true
        //     },
        //     children: [
        //         {
        //             path: "userlist",
        //             name: "userlist",
        //             component: userlist,
        //             meta: {
        //                 icon: "class",
        //                 title: "User List",
        //                 type: onlyAdmin,
        //                 status: true
        //             }
        //         },
        //         {
        //             path: "rolelist",
        //             name: "rolelist",
        //             component: rolelist,
        //             type: onlyAdmin,
        //             meta: {
        //                 icon: "class",
        //                 title: "Role List",
        //                  type: onlyAdmin,
        //                 status: true
        //             }
        //         },
               
        //     ]
        // },
        
        // {
        //     path: "/services",
        //     name: "services",
        //     component: services,
        //     meta: {
        //         icon: "design_services",
        //         title: "Services",
        //         type: onlyAdmin,
        //         status: true
        //     },
        //     children: [
        //         {
        //             path: "serviceslist",
        //             name: "serviceslist",
        //             component: serviceslist,
        //             meta: {
        //                 icon: "class",
        //                 title: "Services List",
        //                 type: onlyAdmin,
        //                 status: true
        //             }
        //         },
        //         {
        //             path: 'servicesadd',
        //             name: 'servicesadd',
        //             component: servicesadd,
        //             meta: {
        //                 icon: 'class',
        //                 title: "Services Add",
        //                 type: onlyAdmin,
        //                 status: true,
        
        //             }
        //         },
        //         {
        //             path: 'servicesedit/:id',
        //             name: 'servicesedit',
        //             component: servicesedit,
        //             props: true,
        //             meta: {
        //                 icon: 'class',
        //                 title: "Services Edit",
        //                 type: onlyAdmin,
        //                 status: false,
        
        //             }
        //         },
               
        //     ]
        // },
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
            path: "/blogproject",
            name: "blogproject",
            component: blogproject,
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
                // {
                //     path: "banner",
                //     name: "banner",
                //     component: bannerlist,
                //     meta: {
                //         icon: "dashboard",
                //         title: "Banner",
                //         type: onlyAdmin,
                //         status: true
                //     }
                // },
                // {
                //     path: "social",
                //     name: "social",
                //     component: social,
                //     meta: {
                //         icon: "dashboard",
                //         title: "Social",
                //         type: onlyAdmin,
                //         status: true
                //     }
                // },
                // {
                //     path: "ourcustomer",
                //     name: "ourcustomer",
                //     component: ourcustomer,
                //     meta: {
                //         icon: "dashboard",
                //         title: "Our Customer",
                //         type: onlyAdmin,
                //         status: true
                //     }
                // },
                // {
                //     path: "contactus",
                //     name: "contactus",
                //     component: contactus,
                //     meta: {
                //         icon: "dashboard",
                //         title: "Contactus",
                //         type: onlyAdmin,
                //         status: true
                //     }
                // },
                // {
                //     path: "aboutus",
                //     name: "aboutus",
                //     component: aboutus,
                //     meta: {
                //         icon: "dashboard",
                //         title: "About Us",
                //         type: onlyAdmin,
                //         status: true
                //     }
                // },
                // {
                //     path: "ourteam",
                //     name: "ourteam",
                //     component: ourteam,
                //     meta: {
                //         icon: "dashboard",
                //         title: "Our Team",
                //         type: onlyAdmin,
                //         status: true
                //     }
                // },
                
            ]
        }
    ]
});

