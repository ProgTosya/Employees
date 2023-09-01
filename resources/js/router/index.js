import { createRouter, createWebHistory } from 'vue-router'

import Tree from "../Components/Tree.vue";
import Dashboard from "../Components/Dashboard.vue";
import CreateEmployee from "../Components/Employees/CreateEmployee.vue";
import EditEmployee from "../Components/Employees/EditEmployee.vue";

const routes = [
    {
        path: '/',
        name: 'tree',
        component: Tree
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/api/employees/create',
        name: 'create',
        component: CreateEmployee
    },
    {
        path: '/api/employees/:id',
        name: 'edit',
        component: EditEmployee
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})
