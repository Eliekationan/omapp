<template>
    <div class="dynamicWidth" style="background-color: white; border-radius: 5px; overflow: auto;">
        <div class="modal-title text-center fw-bold" style="font-size: x-large;
        color: white;
        border-radius: 5px;
        background-color: #4f99ad;">{{ title }}</div>

        <div class="modal-content p-4">
            <div class="row">

                <div class="col-6 mt-4">
                    <label for="">Nom</label>
                    <input type="text" class="form-control" v-model="user.name">
                </div>
                <div class="col-6 mt-4">
                    <label for="">Prenom</label>
                    <input type="text" class="form-control" v-model="user.second_name">
                </div>
                <div class="col-6 mt-4">
                    <label for="">Email</label>
                    <input type="text" class="form-control" v-model="user.email">
                </div>
                <div class="col-6 mt-4">
                    <label for="">Mot de passe</label>
                    <input type="text" class="form-control" v-model="user.password">
                </div>
                <div class="col-6 mt-4">
                    <label for="">Nouveau mot de passe</label>
                    <input type="text" class="form-control" v-model="user.newPassword">
                </div>
                <div class="col-6 mt-4">
                    <label for="">Confirmer</label>
                    <input type="text" class="form-control" v-model="user.confirmPassword">
                </div>
            </div>
            <br>
            
        </div>
        <div class="d-flex justify-content-center my-2">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mx-4" @click="close()">Fermer</button>
                <button type="button" class="btn btn-primary" @click="actions">Envoyer</button>
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
        user: Object,
        
    },
    data(){
        return {
            currUser:null
        }
    },
    beforeCreate(){
        this.currUser = this.user
        this.currUser = {...this.currUser, newPassword:"", confirmPassword:""}
    },
    async mounted(){
    },
    methods: {
        close(){
            closeModal()
        },
        actions(){
            console.log("user", this.user)
            if(this.user){
                if( [null, undefined, ''].includes(this.user?.password)){
                    toast("Veuillez saisir votre mot de passe actuel")
                    return 
                }
                if( [null, undefined, ''].includes(this.user?.newPassword)){
                    toast("Veuillez saisir le nouveau mot de passe")
                    return 
                }
                if( [null, undefined, ''].includes(this.user?.confirmPassword)){
                    toast("Veuillez confirmer le nouveau mot de passe")
                    return 
                }
                axios.post('/api/update-credentials',{
                    id: this.user?.id, 
                    password: this.user?.password,
                    newPassword: this.user?.newPassword,
                    confirmPassword: this.user?.confirmPassword
                })
                .then(res=>{
                    toast(res.data.message)
                    closeModal()
                })
                .catch(err=>{
                    console.log("error", err)
                    closeModal()
                })
            }
            
        }
    }
}
</script>

<style scoped>
@media screen and (max-width:1065px) {
  .dynamicWidth{
    width: 100%;
  }
}
.modal-content{
    z-index: 3;
}
</style>