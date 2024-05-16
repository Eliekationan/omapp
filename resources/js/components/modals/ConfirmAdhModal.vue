<template>
    <div class="" style="background-color: white; width: 40%;border-radius: 5px; overflow: auto;">
        <div class="modal-title text-center fw-bold" style="font-size: x-large;
        color: white;
        border-radius: 5px;
        background-color: #4f99ad;">{{ title }}</div>

        <div class="modal-content p-4">
            <p style="font-size: 18px;" class="text-center fw-bold">{{ mapDecision }}</p>
            <br>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label" for="">Nom</label>
                    </div>
                    <div class="col">
                        <label class="form-label" for="">Prenoms</label>
                    </div>
                    <div class="col">
                        <label class="form-label" for="">Domicile</label>
                    </div>
                    <div class="col">
                        <label class="form-label" for="">Téléphone</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <span>{{ user?.name }}</span>
                    </div>
                    <div class="col">
                        <span>{{ user?.second_name }}</span>
                    </div>
                    <div class="col">
                        <span>{{ user?.domicile }}</span>
                    </div>
                    <div class="col">
                        <span>{{ user?.telephone }}</span>
                    </div>
                </div>
            </div>
            <br>
            <div v-if="error_appier">
                <a href="" style="color:red !important">Veuillez cliquer sur ce lien pour soumettre à l'adherant une modification de son {{ error_attribut }}</a>
            </div>
        </div>
        <div class="d-flex justify-content-center my-2">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mx-4" @click="close()">Fermer</button>
                <button type="button" class="btn btn-success" @click="launchMigrationProcessing">Confirmer</button>
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
        decision: String
    },
    computed:{
        mapDecision(){
            if(this.decision == "ACCEPT") return `Vous êtes sur le point d'accepter cet utilisateur à faire partir de vos membres. Voulez-vous vraiment confirmer cette action ?`
            else return `Vous êtes sur le point de refuser cet utilisateur de faire partir de vos membres`
        }
    },
    data(){
        return {
            error_attribut: null,
            error_appier: false
        }
    },
    mounted(){
       
    },
    methods: {
        close(){
            closeModal()
        },
        launchMigrationProcessing(){
            axios.post('/api/migrate-from-adhto-user',{...this.user})
                .then(res=>{
                    toast(res.data.message)
                    if(!res.data.is_success){
                        if(res.data.code_error == "ATT_MISSING"){
                            this.error_appier = true
                            this.error_attribut = res.data.attribut
                        }
                    }
                    // closeModal()
                })
                .catch(err=>{
                    console.log("error", err)
                })
        },
        
    }
}
</script>

<style scoped>
.modal-content{
    z-index: 3;
}
</style>