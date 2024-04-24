<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";
const router = useRouter()
let schoolclasses = ref([])

let form = ref({id:''})

const props = defineProps({
    id:{
        type:String,
        default:''
    }
})

onMounted(async ()=>
{
    getStudentById()
    getAllclasses()
    getStudentById()
})

const  getAllclasses  = async ()=>
{
    let response = await axios.get('/api/getAllclasses')
    console.log(response)
    schoolclasses.value = response.data.schoolclasses
}

const getStudentById = async ()=>
{

    let response = await axios.get(`/api/editstudent/${props.id}`)
    console.log(response)
    form.value = response.data.student
}

const Update =(id) =>
{
    let formdata = new FormData()
    formdata.append('fname',form.value.fname)
    formdata.append('lname',form.value.lname)
    formdata.append('phone',form.value.phone)
    formdata.append('email',form.value.email)
    formdata.append('level_id',form.value.level_id)
    axios.post(`/api/update_student/${form.value.id}`,formdata)
    router.push('/')
}
</script>

<template>
    <div class="container">
        <form method="post" >
            <div class="card " >
                <div class="card-dialog" role="document">
                    <div class="card-content">
                        <div class="card-header">
                            <h5 class="card-title" style="color: #006fbb">Update Student</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="inputName" class="form-label" style="color: #006fbb">Nom</label>
                                <input type="text" class="form-control" id="inputName" v-model="form.fname">
                            </div>
                            <div class="mb-3">
                                <label for="inputLastName" class="form-label" style="color: #006fbb">Prénom</label>
                                <input type="text" class="form-control" id="inputLastName" v-model="form.lname">
                            </div>
                            <div class="mb-3">
                                <label for="inputEmail" class="form-label" style="color: #006fbb" >Email</label>
                                <input type="email" class="form-control" id="inputEmail" v-model="form.email">
                            </div>
                            <div class="mb-3">
                                <label for="inputPhone" class="form-label" style="color: #006fbb">Téléphone</label>
                                <input type="text" class="form-control" id="inputPhone" v-model="form.phone" >
                            </div>
                            <div class="mb-3">
                                <label for="inputClass" class="form-label" style="color: #006fbb">Classe</label>
                                <select class="form-select" id="inputClass" v-model="form.level_id">
                                    <option v-for="item in schoolclasses" :key="item.id" :value="item.id">{{item.nom}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" @click="Update(form.id)" >Modifier</button>
                            <a href="#" class="btn btn-danger" >Annuler</a>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</template>
