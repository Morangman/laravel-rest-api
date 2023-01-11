import { createRouter, createWebHistory} from 'vue-router'

import AllUsers from '../components/AllUsers.vue';
import AddUser from '../components/AddUser.vue';
import EditUser from '../components/EditUser.vue';
 
const routes = [
    {
        name: 'home',
        path: '/',
        component: AllUsers
    },
    {
        name: 'add',
        path: '/add',
        component: AddUser
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditUser
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;