<script setup>
import  {onMounted ,ref} from "vue";
import {useRouter} from "vue-router";
import axios from "axios";
const router = useRouter()
let students = ref([])
let schoolclasses = ref([])

let showModal = ref(false); // Variable pour contrôler l'affichage du modal

let form = ref({id:''})


onMounted(async ()=>{
    getStudents()
    getAllclasses()
})


const  getAllclasses  = async ()=>
{
    let response = await axios.get('/api/getAllclasses')
    console.log(response)
    schoolclasses.value = response.data.schoolclasses
}

const getStudents = async ()=>
{
     let  response = await axios.get('/api/get_students')
     console.log(response)
     students.value = response.data.students
}
const openModal = () =>
{
    showModal.value = true; // Afficher le modal lorsque le bouton "New Student" est cliqué
}

const closeModal = () =>
{
    showModal.value = false; // Fermer le modal
}
let form1 = ref([])

const save =  ()=>
{
   let formdata = new FormData()
    formdata.append('fname',form1.value.fname)
    formdata.append('lname',form1.value.lname)
    formdata.append('phone',form1.value.phone)
    formdata.append('email',form1.value.email)
    formdata.append('level_id',form1.value.level_id)
    axios.post('/api/add_student',formdata)
    window.location='http://127.0.0.1:8000/'
}

const deletestudent =  (id)=>
{
    let response =  axios.get('/api/deletestudent/'+id)
    console.log(response)
    //student.value = response.data.student
    //router.push('/')
    window.location='http://127.0.0.1:8000/'
}

const onEdit=(id)=>
{
    router.push('/Students/edit/'+id)
}

</script>
<template>
    <div class="container">
        <!--==================== STUDENTS LIST ====================-->
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Students List</h2>
                </div>
                <div>
                    <button class=" btn btn-success"  @click="openModal">New Student</button>
                </div>
            </div>
            <div class="table card__content">
                <div class="table--filter">
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p class="table--filter--link table--filter--link--active">All</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="relative">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" type="text" placeholder="Search student">
                    </div>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Classe</th>
                        <th>Action(s)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-if="students.length > 0">
                        <tr v-for="student in students" :key="student.id">
                            <td><a href="#">{{ student.id }}</a></td>
                            <td>{{ student.lname }}</td>
                            <td>{{ student.fname }}</td>
                            <td>{{ student.phone }}</td>
                            <td>{{ student.email }}</td>
                            <td>{{ student.schoolclass.nom }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm me-1"  @click="onEdit(student.id)">
                                    <i class="material-icons me-1">edit</i>
                                </button>
                                <button class="btn btn-danger btn-sm me-1" @click="deletestudent(student.id)">
                                    <i class="material-icons me-1">delete</i>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr v-else>
                        <td colspan="7">Students not found</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- Modal de création d'étudiant -->
            <div class="modal" :class="{ 'show': showModal }" tabindex="-1" role="dialog" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create New Student</h5>
                            <button type="button" class="btn-close" aria-label="Close" @click="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="inputName" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="inputName" v-model="form1.fname">
                            </div>
                            <div class="mb-3">
                                <label for="inputLastName" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="inputLastName" v-model="form1.lname">
                            </div>
                            <div class="mb-3">
                                <label for="inputEmail" class="form-label" >Email</label>
                                <input type="email" class="form-control" id="inputEmail" v-model="form1.email">
                            </div>
                            <div class="mb-3">
                                <label for="inputPhone" class="form-label" >Téléphone</label>
                                <input type="text" class="form-control" id="inputPhone" v-model="form1.phone" >
                            </div>
                            <div class="mb-3">
                                <label for="inputClass" class="form-label">Classe</label>
                                <select class="form-select" id="inputClass" v-model="form1.level_id">
                                    <option v-for="item in schoolclasses" :key="item.id" :value="item.id">{{item.nom}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                            <button type="submit" class="btn btn-primary" @click="save()">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</template>


