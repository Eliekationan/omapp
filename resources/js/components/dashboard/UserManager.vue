<template>
    <div class="d-md-flex justify-content-around align-items-center mb-4">

        <div class="title align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="text-uppercase"
                    style="font-size: x-large; color:gray; font-family: Verdana, Geneva, Tahoma, sans-serif;"><b>Liste
                        des membres</b></div>
            </div>
            <div class="d-flex align-items-center">
                <h5 class="mx-2 mb-0">Total:</h5>{{ users.total }}
            </div>
        </div>
        <div class="title align-items-center justify-content-between">
            <div class="input-group" style="width: 80%;">
                <input type="text" class="form-control" placeholder="Search" aria-label="Search"
                    aria-describedby="basic-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
            </div>
            <div class="" title="Ajouter un nouveau membre a la liste">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="bi bi-plus" style="font-size: 20px;"></i>
                </button>
            </div>
        </div>
        <input accept=".xlsx, .xls" type="file" id="input" @change="exportData" />
    </div>
    <div class="" style="height: calc(88%); width: 100%; overflow-x: auto;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Domicile</th>
                    <th>Tel</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users.data" :key="index + 'dfg'">
                    <td>{{ index + 1 }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.second_name }}</td>
                    <td>{{ user.adresse }}</td>
                    <td>{{ user.telephone }}</td>
                    <td>{{ user.email }}</td>
                    <td :title="user?.roles[0]?.role_name">{{ textTrucate(user?.roles[0]?.role_name, 20) }}</td>
                    <td>
                        <i @click="showUpdateModal(user)" class="bi bi-pen-fill" style="color:#2c7c99; cursor:pointer"></i>
                    </td>
                    <td>
                        <i @click="deleteUser(user)" class="bi bi-trash" style="color:red; font-size: 17px;cursor: pointer;"></i>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" style="cursor: pointer;" v-for="(link, index) in users.links" :key="index +'rf'">
                    <span class="page-link" :class="{'active':link.active, 'disabled': index == 1}" @click="previousPage()" v-if="index==0">{{link.label.split(';')[1]}}</span>
                    <span class="page-link" :class="{'active':link.active}" @click="gotoPage(link.url)" v-if="index>0 && index <users?.links?.length - 1">{{link.label}}</span>
                    <span class="page-link" :class="{'active':link.active, 'disabled': index == users.last_page}" @click="nextData()" v-if="index==users?.links?.length - 1">{{link.label.split(' ')[0]}}</span>
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
                                <label for="name" class="form-label">Nom</label>
                                <input id="name" class="form-control" type="text" v-model="user.name">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="second_name" class="form-label">Prenom</label>
                                <input id="second_name" class="form-control" type="text" v-model="user.second_name">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="text" v-model="user.email">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="birth_date" class="form-label">Date de naissance</label>
                                <input id="birth_date" class="form-control" type="date" v-model="user.birth_date">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="ville" class="form-label">Ville</label>
                                <select id="ville" class="form-select single-select" type="text" v-model="user.ville">
                                    <option :value="city.city" v-for="(city, index) in cities" :key="index">{{ city.city
                                        }}</option>
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="domicile" class="form-label">Domicile</label>
                                <input id="domicile" class="form-control" type="text" v-model="user.domicile">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="nature_piece" class="form-label">Nature de la pièce d'identité</label>
                                <input id="nature_piece" class="form-control" type="text" v-model="user.nature_piece">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="numero_piece" class="form-label">N° de la pièce</label>
                                <input id="numero_piece" class="form-control" type="text" v-model="user.numero_piece">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="secteur_activite" class="form-label">Secteur d'activité</label>
                                <select id="secteur_activite" class="form-select single-select" type="text"
                                    v-model="user.secteur_activite">
                                    <option value="Formel">Formel</option>
                                    <option value="Informel">Informel</option>
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="fonction" class="form-label">Fonction</label>
                                <input id="fonction" class="form-control" type="text" v-model="user.fonction">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="grade" class="form-label">Grade</label>
                                <input id="grade" class="form-control" type="text" v-model="user.grade">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="grade" class="form-label">Téléphone</label>
                                <input id="grade" class="form-control" type="text" v-model="user.phone">
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">Retraité(e)</label>
                                <div class="d-flex">
                                    <div class="d-flex mx-2">
                                        <input id="Oui" type="radio" value="Oui" v-model="user.retraite">
                                        <label for="Oui">Oui</label>
                                    </div>
                                    <div class="d-flex">
                                        <input id="Non" type="radio" value="Non" v-model="user.retraite">
                                        <label for="Non">Non</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="sendUsers">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import axios from 'axios'

import readXlsxFile from 'read-excel-file'
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { openModal } from 'jenesius-vue-modal';
import Modal from '../modals/Modal.vue';
import ConfirmModal from '../modals/ConfirmModal.vue';
export default {
    components: {
        Modal
    },
    mounted() {
        axios.post("api/get-cities", {})
            .then(res => this.cities = res.data)
        axios.get("api/get-users", {})
            .then(res => this.users = res.data)
        axios.get('api/get-roles',{})
            .then(res => this.roles = res.data)
    },
    data() {
        return {
            user: {
                name: "",
                second_name: "",
                email: "",
                birth_date: "",
                domicile: "",
                ville: "",
                fonction: "",
                secteur_activite: "",
                grade: "",
                retraite: "",
                phone: ""
            },
            cities: [],
            users: [],
            userToUpdate: null,
            roles:null
        }
    },
    methods: {
        sendUsers() {
            axios.post("/api/store-user", { ...this.user })
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
            axios.get(this.users.next_page_url, {})
            .then(res => this.users = res.data)
        },
        previousPage(){
            axios.get(this.users.prev_page_url, {})
            .then(res => this.users = res.data)
        },
        gotoPage(url){
            axios.get(url, {})
            .then(res => this.users = res.data)
        },
        showUpdateModal(user){
            this.userToUpdate = user
            const props = {
                title: `Modification de l'utilisateur ${user.name}`,
                userData: user,
                cities: this.cities,
                roles: this.roles
            }
            openModal(Modal, props)
        },
        deleteUser(user){
            const props = {
                title: `Suppression d'utilisateur`,
                message:`Vous êtes sur le point de supprimer cet utilisateur: ${user.name}`,
                user: user
            }
            openModal(ConfirmModal, props)
        },
        textTrucate(str, length = 20, ending = '...') {
            if (str?.length > length) {
                return str.substring(0, length - ending.length) + ending;
            }
            return str;
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