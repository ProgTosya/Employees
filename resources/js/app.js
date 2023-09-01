import { createApp } from 'vue/dist/vue.esm-bundler.js';
import router from './router'

import Tree from "./Components/Tree.vue";
import Dashboard from "./Components/Dashboard.vue";
import CreateEmployee from "./Components/Employees/CreateEmployee.vue";
import EditEmployee from "./Components/Employees/EditEmployee.vue";

createApp({
    components: {
        Tree, Dashboard, CreateEmployee, EditEmployee
    }
}).use(router).mount('#app')
