<template>
    <div class="contrib-modal" style="">
        <div class="modal-title text-center fw-bold" style="font-size: x-large;
        color: white;
        border-radius: 5px;
        background-color: #4f99ad;">{{ title }}</div>
        <div class="d-flex justify-content-center align-items-center mt-2 mb-2">
            <div>
                <div><i class="bi bi-person-circle" style="font-size: 80px;"></i></div>
            </div>
            <div style="padding-left:4px ;">
                <div> <i><span class="fw-bold">Nom: </span>{{ contrib.name }}</i> </div>
                <div> <i><span class="fw-bold">Prenom: </span>{{ contrib.second_name }}</i> </div>
                <div> <i><span class="fw-bold">Email: </span>{{ contrib.email }}</i> </div>
            </div>
            

        </div>

        <div class="modal-content p-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>Cotisation annuelle de {{ year }}</div>
                        <div class="fw-bold">Total: {{ getTotal(contrib) }} XOF</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-sm-4 col-md-3" v-for="(row, index) in contrib?.contributions" :key="index+'mlkj'">
                            <div class="card px-0">
                                <div class="card-header" :class="{'bg-success':row.amount, 'bg-danger':!row.amount}">
                                    <div class="d-flex justify-content-between">
                                        <span>{{ months[row?.month] }}</span>
                                        <i @click="updateAdh(row)" class="bi bi-arrow-clockwise" :style="row.amount ? 'color:red' : 'color:green'" style="cursor: pointer"></i>
                                    </div>
                                    
                                </div>
                                <div class="card-body" style="background-color: #53536D; opacity: 0.8;">
                                    <div class="row text-white">1000</div>
                                    <div class="col-12 text-end text-white">{{ row.amount ? 'Soldé': 'Non soldé'}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary mx-4" @click="close()">Fermer</button>
                <button type="button" class="btn btn-primary" @click="updateRole">Envoyer</button>
            </div> -->
        </div>
    </div>
</template>

<script>
import { closeModal } from "jenesius-vue-modal"
import { toast } from 'vue3-toastify';
import axios from 'axios';
export default {
    inject: ["EventBus"],
    props: {
        title: String,
        contrib: Object,
        year: Number,
    },
    computed:{
        
    },
    data() {
        return {
            roleToUpdate: {
                role_name: "",
                description: ""
            },
            months:{
                1:"Janvier",
                2:"Février",
                3:"Mars",
                4:"Avril",
                5:"Mai",
                6:"Juin",
                7:"Juillet",
                8:"Aout",
                9:"Septembre",
                10:"Octobre",
                11:"Novembre",
                12:"Décembre",
            }
        }
    },
    mounted() {
        this.roleToUpdate = this.roleData
    },
    methods: {
        getTotal(user) {
            // console.log('user', user)
            const total = user?.contributions?.reduce(
                (accumulator, el) => accumulator + Number(el.amount), 0,);
            return total
        },
        close() {
            closeModal()
        },
        
        updateAdh(contrib){
            console.log("contrib", contrib)
            axios.post("/api/update-one-contribution", {...contrib, user_id:this.contrib.id, year: this.year}).
            then(res=>{
                if(res.data.is_success){
                    toast(res.data.message)
                    console.log("this", this.EventBus.emit)
                    this.EventBus.emit("reload-contrib", () => {})
                }
            }).catch(err=>console.log(err))
        }
    }
}
</script>

<style scoped>
.contrib-modal{
    background-color: white;
    width: 50%;
    border-radius: 5px;
    margin-top: 10px;
    overflow: auto;
}
@media screen and (max-width: 426px) {
    .contrib-modal{
        background-color: white; 
        width: 100%;
        margin-top: 45px;
        border-radius: 5px; 
        overflow: auto;
    }
}
@media screen and (min-width: 426px) and (max-width:769px){
    .contrib-modal{
        background-color: white; 
        width: 100%;
        border-radius: 5px; 
        margin-top: 45px;
        overflow: auto;
    }
}
@media screen and (min-width: 769px) and (max-width:1024px){
    .contrib-modal{
        background-color: white; 
        width: 100%;
        border-radius: 5px; 
        margin-top: 45px;
        overflow: auto;
    }
}
.modal-content {
    z-index: 3;
}
.bg-header{
    background-color: #9b9b9b;
    border-bottom: white solid 1px;
}

.text-danger{
    color: red
}
</style>