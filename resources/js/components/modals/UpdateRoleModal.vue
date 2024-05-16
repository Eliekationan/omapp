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
                        <label for="name" class="form-label">Intitulé du role</label>
                        <input id="name" class="form-control" type="text" v-model="roleToUpdate.role_name">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="second_name" class="form-label">Description</label>
                        <textarea class="form-control" cols="30" rows="1" v-model="roleToUpdate.description"></textarea>
                        <!-- <input id="second_name" class="form-control" type="text" > -->
                    </div>
                </div>
            </form>
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mx-4" @click="close()">Fermer</button>
                <button type="button" class="btn btn-primary" @click="updateRole">Envoyer</button>
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
        roleData: Object
    },
    data(){
        return {
            roleToUpdate:{
                role_name:"",
                description:""
            }
        }
    },
    mounted(){
        this.roleToUpdate = this.roleData
    },
    methods: {
        close(){
            closeModal()
        },
        updateRole(){
            
            if(this.roleData){
                if([null, "", undefined].includes(this.roleToUpdate.role_name)){
                    toast("Veuillez renseigner la ville de l'utilisateur")
                    return
                }
                axios.post("/api/update-role", { ...this.roleToUpdate })
                    .then((res) => {
                        toast(res.data.message, {autoClose:5000})
                    });
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