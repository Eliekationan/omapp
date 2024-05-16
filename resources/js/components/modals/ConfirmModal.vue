<template>
    <div class="" style="background-color: white; width: 40%;border-radius: 5px; overflow: auto;">
        <div class="modal-title text-center fw-bold" style="font-size: x-large;
        color: white;
        border-radius: 5px;
        background-color: #4f99ad;">{{ title }}</div>

        <div class="modal-content p-4">
            <p class="text-center fw-bold">{{ message }}</p>
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
        message: Object,
        user: Object,
        role: Object,
        share: Boolean,
        file: Object
    },
    data(){
        return {
            
        }
    },
    mounted(){
       
    },
    methods: {
        close(){
            closeModal()
        },
        actions(){
            if(this.user){
                axios.post('/api/delete-user',{...this.user})
                .then(res=>{
                    toast(res.data.message)
                    closeModal()
                })
                .catch(err=>{
                    console.log("error", err)
                    closeModal()
                })
            }
            if(this.role){
                axios.post('/api/delete-role',{...this.user})
                .then(res=>{
                    toast(res.data.message)
                    closeModal()
                })
                .catch(err=>{
                    console.log("error", err)
                    closeModal()
                })
            }
            if(this.share){
                axios.post("/api/share-file", {...this.file})
                .then(res=>{
                    toast(res.data.message)
                    closeModal()
                })
                .catch(error=>{
                    console.log("error", err)
                    closeModal()
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