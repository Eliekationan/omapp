<template>
    <div class="d-md-flex justify-content-around align-items-center mb-4">

        <div class="title align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="text-uppercase"
                    style="font-size: x-large; color:gray; font-family: Verdana, Geneva, Tahoma, sans-serif;"><b>Liste des rôles</b></div>
            </div>
            <div class="d-flex align-items-center">
                <h5 class="mx-2 mb-0">Total:</h5>{{ roles.total }}
            </div>
        </div>
        <div class="title align-items-center justify-content-between">
            <div class="input-group" style="width: 80%;">
                <input type="text" class="form-control" placeholder="Search" aria-label="Search"
                    aria-describedby="basic-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
            </div>
            <div class="" title="Ajouter un nouveau rôle à la liste">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="bi bi-plus" style="font-size: 20px;"></i>
                </button>
            </div>
        </div>
        <!-- <input accept=".xlsx, .xls" type="file" id="input" @change="exportData" /> -->
    </div>
    <div class="" style="height: calc(88%); width: 100%; overflow-x: auto;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Role name</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(role, index) in roles.data" :key="index + 'dfg'">
                    <td>{{ index + 1 }}</td>
                    <td>{{ role.role_name }}</td>
                  
                    <td>{{ role.description }}</td>
                    <td>
                        <i @click="showUpdateModal(role)" class="bi bi-pen-fill" style="color:#2c7c99; cursor:pointer"></i>
                    </td>
                    <td>
                        <i @click="deleteRole(role)" class="bi bi-trash" style="color:red; font-size: 17px;cursor: pointer;"></i>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" style="cursor: pointer;" v-for="(link, index) in roles.links" :key="index +'rf'">
                    <span class="page-link" :class="{'active':link.active, 'disabled': index == 1}" @click="previousPage()" v-if="index==0">{{link.label.split(';')[1]}}</span>
                    <span class="page-link" :class="{'active':link.active}" @click="gotoPage(link.url)" v-if="index>0 && index <roles?.links?.length - 1">{{link.label}}</span>
                    <span class="page-link" :class="{'active':link.active, 'disabled': index == roles.last_page}" @click="nextData()" v-if="index==roles?.links?.length - 1">{{link.label.split(' ')[0]}}</span>
                </li>
            </ul>
        </nav>
        </div>
        <br>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable custom-modal">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #4f99ad;">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Formulaire de création de compte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="row">
                            <div class="col-6 mt-3">
                                <label for="name" class="form-label">Intitulé du role</label>
                                <input id="name" class="form-control" type="text" v-model="role.role_name">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="second_name" class="form-label">Description</label>
                                <input id="second_name" class="form-control" type="text" v-model="role.description">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="sendRole">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

import readXlsxFile from 'read-excel-file'
import { toast } from 'vue3-toastify';
import { openModal } from 'jenesius-vue-modal';
import 'vue3-toastify/dist/index.css';
import UpdateRoleModal from '../modals/UpdateRoleModal.vue';
import ConfirmModal from '../modals/ConfirmModal.vue';
export default {
    components: {
    },
    mounted() {
        axios.post("api/get-cities", {})
            .then(res => this.cities = res.data)
        axios.get("api/get-roles", {})
            .then(res => this.roles = res.data)
    },
    data() {
        return {
            cities: [],
            role:{
                role_name:"",
                description:""
            },
            roles: [],
            roleToUpdate:null
        }
    },
    methods: {
        sendRole() {
            if(['', undefined, null].includes(this.role.role_name)){
                toast("Veuillez renseignez l'intutilé du role que vous voulez créer")
                return
            }
            axios.post("/api/store-role", { ...this.role })
                .then((res) => {
                    toast(res.data.message, {autoClose:5000})
                })
        },
        exportData(event) {
            const files = event.target.files
            const file = files[0]
            let data = []
            readXlsxFile(file).then((rows) => {
                const vlines = rows.filter((line) => line.includes("Côte d'Ivoire"))
                let line = vlines.map(el => {
                    return {
                        city: el[0],
                        city_ascii: el[1],
                        lat: el[2],
                        lng: el[3],
                        country: el[4]
                    }
                })
                console.log({ line: line })
                // for(const el of vlines){
                //     // console.log(el)
                // }
                axios.post("api/store-cities-data", { data: line }).then(res => {
                    console.log(res)
                })
                console.log(vlines)
            })
        },
        nextData(){
            axios.get(this.roles.next_page_url, {})
            .then(res => this.roles = res.data)
        },
        previousPage(){
            axios.get(this.roles.prev_page_url, {})
            .then(res => this.roles = res.data)
        },
        gotoPage(url){
            axios.get(url, {})
            .then(res => this.roles = res.data)
        },
        showUpdateModal(role){
            const props = {
                title: `Modification du rôle ${role.role_name}`,
                roleData: role
            }
            openModal(UpdateRoleModal, props)
        },
        deleteRole(role){
            const props = {
                title: `Suppression d'utilisateur`,
                message:`Vous êtes sur le point de supprimer ce rôle: ${role.role_name}`,
                role: role
            }
            openModal(ConfirmModal, props)
        },
    }
}
</script>

<style scoped>
.custom-modal {
    max-width: 600px;
    width: 100%;
}

@media screen and (min-width: 412px) {
    .title {
        display: flex;
    }
}
</style>