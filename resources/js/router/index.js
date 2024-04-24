import {createRouter , createWebHistory} from "vue-router"
import studentIndex from '../components/Students/index.vue'
import studentEdit from '../components/Students/edit.vue'
const routes = [
    {
        path:'/',
        component : studentIndex
    },
    {
        path:'/Students/edit/:id',
        component : studentEdit,
        props:true
    }
]

const router = createRouter({
    history : createWebHistory(),
    routes
})

export default router
