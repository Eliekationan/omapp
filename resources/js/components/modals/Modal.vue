<template>
    <div class="" style="background-color: white; width: 40%;border-radius: 5px; overflow: auto;">
        <div class="modal-title text-center fw-bold" style="font-size: x-large;
        color: white;
        border-radius: 5px;
        background-color: #4f99ad;">{{ title }}</div>

        <div class="modal-content p-4">
            <form action="">
                <div class="row">
                    <div class="col-6 mt-3">
                        <label for="name" class="form-label">Nom</label>
                        <input id="name" class="form-control" type="text" v-model="userToUpdate.name">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="second_name" class="form-label">Prenom</label>
                        <input id="second_name" class="form-control" type="text" v-model="userToUpdate.second_name">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" class="form-control" type="text" v-model="userToUpdate.email">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="birth_date" class="form-label">Date de naissance</label>
                        <input id="birth_date" class="form-control" type="date" v-model="userToUpdate.birth_date">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="ville" class="form-label">Ville <i class="bi bi-star-fill text-danger"></i></label>
                        <select id="ville" class="form-select single-select" type="text" v-model="userToUpdate.ville">
                            <option :value="city.city" v-for="(city, index) in cities" :key="index">{{ city.city
                                }}</option>
                        </select>
                    </div>
                    <div class="col-6 mt-3">
                        <label for="domicile" class="form-label">Domicile</label>
                        <input id="domicile" class="form-control" type="text" v-model="userToUpdate.domicile">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="nature_piece" class="form-label">Nature de la pièce d'identité</label>
                        <input id="nature_piece" class="form-control" type="text" v-model="userToUpdate.nature_piece">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="numero_piece" class="form-label">N° de la pièce</label>
                        <input id="numero_piece" class="form-control" type="text" v-model="userToUpdate.numero_piece">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="secteur_activite" class="form-label">Secteur d'activité</label>
                        <select id="secteur_activite" class="form-select single-select" type="text"
                            v-model="userToUpdate.secteur_activite">
                            <option value="Formel">Formel</option>
                            <option value="Informel">Informel</option>
                        </select>
                    </div>
                    <div class="col-6 mt-3">
                        <label for="fonction" class="form-label">Fonction</label>
                        <input id="fonction" class="form-control" type="text" v-model="userToUpdate.fonction">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="grade" class="form-label">Grade</label>
                        <input id="grade" class="form-control" type="text" v-model="userToUpdate.grade">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="grade" class="form-label">Téléphone</label>
                        <input id="grade" class="form-control" type="text" v-model="userToUpdate.phone">
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label">Retraité(e)</label>
                        <div class="d-flex">
                            <div class="d-flex mx-2">
                                <input id="Oui" type="radio" value="Oui" v-model="userToUpdate.retraite">
                                <label for="Oui">Oui</label>
                            </div>
                            <div class="d-flex">
                                <input id="Non" type="radio" value="Non" v-model="userToUpdate.retraite">
                                <label for="Non">Non</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <label for="grade" class="form-label">Rôle</label>
                        <select id="grade" class="form-select single-select" type="text" v-model="userToUpdate.roles[0].role_name">
                            <option :value="role.role_name" v-for="(role, index) in roles" :key="index +'zte'">{{ role.role_name }}</option>
                        </select>
                    </div>
                </div>
            </form>
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mx-4" @click="close()">Fermer</button>
                <button type="button" class="btn btn-primary" @click="updateUsers">Envoyer</button>
            </div>
        </div>
    </div>
</template>

<script>
import {closeModal} from "jenesius-vue-modal"
import { toast } from 'vue3-toastify';
export default {
    props: {
        title: String,
        userData: Object,
        cities: Array,
    },
    data(){
        return {
            userToUpdate:{
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
                phone: "",
                roles:[{role_name:""}]
            }
        }
    },
    mounted(){
        this.userToUpdate = this.userData
        this.userToUpdate.domicile = this.userData?.adresse
        this.userToUpdate.ville = this.cities.find(el=>el.id = this.userData.city_id)?.city
    },
    methods: {
        close(){
            closeModal()
        },
        updateUsers(){
            if(this.userData){

                if([null, "", undefined].includes(this.userToUpdate.ville)){
                    toast("Veuillez renseigner la ville de l'utilisateur")
                    return
                }
                axios.post("/api/update-user", { ...this.userToUpdate })
                    .then((res) => {
                        toast(res.data.message, {autoClose:5000})
                    })
            }
        }
    }
}
</script>

<style scoped>
.modal-content{
    z-index: 3;
}
</style>