<template>
    <div class="mb-2 d-md-flex align-items-center justify-content-between sub-menu border border-2 rounded py-2" style="position: sticky; top:0px">
        <h4 class="md-h4 mb-0 fw-bold text-uppercase mx-2" style="color: grey;">Cotisation annuelle de</h4>
        <div class="d-flex justify-content-between">
            <h6 class="sm-h4 mb-0 fw-bold text-uppercase mx-2" style="color: grey;">Cotisation annuelle de</h6>
            <!-- <input class="form-control" v-model="annee" type="text" placeholder="Année" @change="getContributions"> -->
            <div><i @click="decrementYear()" class="bi bi-caret-left-fill"></i><span class="border border-2 p-1 rounded">{{ annee }}</span><i @click="incrementYear()" class="bi bi-caret-right-fill"></i></div>
        </div>
        <hr>
        <div style="margin-left: 12px;" class="banner-total-zone">
            <span class="fw-bold">Somme total encaisée: <span style="color:red; text-decoration: underline">{{ totalPerYear }} XOF</span></span>
        </div>
        <div style="margin-left: 12px;" class="banner-total-zone">
            <span  class="fw-bold">Part annuelle: <span style="color:red; text-decoration: underline">{{ Number(totalPerYear) ? Number.parseFloat(Number(getTotal()) / Number(totalPerYear)).toFixed(2): 0 }} %</span></span>
        </div>
    </div>
    <div class="card-body">
        <div class="card-content table-responsive" style="overflow-y: auto;">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Montant</th>
                        <th>Soldé le</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(month, index) in contributions.contributions" :key="index + 'dfg'" style="cursor: pointer;">
                        <td>{{ month?.month }}</td>
                        <td>{{ month?.amount }}</td>
                        <td>{{ month?.created_at }}</td>
                        <td :class="{ 'bg-success': Number(month.amount) != 0, 
                        'bg-danger': Number(month.amount) == 0}" class="text-white">{{ month?.amount ? 'Soldé' : 'Non soldé' }}</td>
                    </tr>
                    <br>
                    <tr>
                        <!-- #a9a9a9 -->
                        <td style="background-color: black" class=" text-white" colspan="2">Total</td>
                        <td style="background-color: black" class=" text-white"  colspan="13">{{getTotal()}} XOF</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import UpdateContribModal from '../modals/UpdateContribModal.vue'
import axios from 'axios'
import Auth from '../../services/auth.js'
import { toast } from 'vue3-toastify';
import { openModal } from 'jenesius-vue-modal';
import 'vue3-toastify/dist/index.css';
export default {
    inject: ["EventBus"],
    components:{
        UpdateContribModal
    },
    props:{
        authUser: Object
    },
    computed:{
        
    },
    async mounted() {
        await this.authUserData();
        this.getContributions()
        this.someTotalOfYear()
        this.EventBus.on("reload-contrib", this.getContributions());
    },
    data() {
        return {
            annee: 2024,
            searchModel:"",
            totalPerYear:0,
            contributions:[],
            months: [
                {name: "Janvier", statut:"", date_operation:""},
                {name: "Fevrier", statut:"", date_operation:""},
                {name: "Mars", statut:"", date_operation:""},
                {name: "Avril", statut:"", date_operation:""},
                {name: "Mai", statut:"", date_operation:""},
                {name: "Juin", statut:"", date_operation:""},
                {name: "Juillet", statut:"", date_operation:""},
                {name: "Aout", statut:"", date_operation:""},
                {name: "Septembre", statut:"", date_operation:""},
                {name: "Octobre", statut:"", date_operation:""},
                {name: "Novembre", statut:"", date_operation:""},
                {name: "Décembre", statut:"", date_operation:""},
               ,
            ],
            authUser: null
            
        }
    },
    methods: {
        async authUserData() {
            await Auth.loadUserData()
                .then((res) => {
                    this.authUser = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        decrementYear(){
            this.annee = this.annee - 1
            this.getContributions()
        },
        incrementYear(){
            this.annee = this.annee + 1
            this.getContributions()
        },
        async someTotalOfYear(){
            await axios.post("/api/get-total-per-year", {year: this.annee}).
                then(res=>{
                    this.totalPerYear = res.data.totalAmount
                }).catch(err=>console.log(err))
            return totalPerYear
        },
        searchContribUser(){
            if(["", null, undefined].includes(this.searchModel)){
                this.getContributions()
            }
            else{
                axios.post("/api/search-contribution", {year: this.annee, keyword: this.searchModel}).
                then(res=>{
                    if (!res.data?.is_success) {
                        toast(res.data.message, { autoClose: 5000 })
                        return
                    }
                    else {
                        this.reformatData(res)
                    }
                })
            }
        },
        getTotal() {
            // console.log('user', user)
            const total = this.contributions?.contributions?.reduce(
                (accumulator, el) => accumulator + Number(el.amount), 0,);
            return total
        },
        getContributions() {
            const year = this.annee
            axios.post('/api/get-contribution-for-user', {
                year:year, user_id: this.authUser.id})
                .then((res) => {
                    if (!res.data?.is_success) {
                        toast(res.data.message, { autoClose: 5000 })
                        return
                    }
                    else {
                        console.log("res", res)
                        this.contributions = res.data.contribs
                        
                        this.reformatData(res)
                    }

                })
            this.someTotalOfYear()
        },
        reformatData(res) {
            this.contributions = res.data.contribs
           
            const contribMonths = this.contributions.contributions.map((el, key)=>{
                return {...el, month: this.months[key]?.name, created_at: el.created_at.split('T')[0]}
            })
            console.log("lines", contribMonths)
            this.contributions.contributions = contribMonths
        },

        nextData() {
            axios.get(this.lines.next_page_url, {})
                .then(res => {
                    if (!res.data?.is_success) {
                        toast(res.data.message, { autoClose: 5000 })
                        return
                    }
                    else {
                        this.reformatData(res)
                    }
                })
        },
        previousPage() {
            axios.get(this.lines.prev_page_url, {})
                .then(res => {
                    if (!res.data?.is_success) {
                        toast(res.data.message, { autoClose: 5000 })
                        return
                    }
                    else {
                        this.reformatData(res)
                    }
                })
        },
        gotoPage(url) {
            axios.get(url, {})
                .then(res => {
                    if (!res.data?.is_success) {
                        toast(res.data.message, { autoClose: 5000 })
                        return
                    }
                    else {
                        this.reformatData(res)
                    }
                })
        },
        openContributionModal(contrib){
            // alert(0)
            const props = {
                title: `PORTEFEUILLE DE COTISATION`,
                contrib: contrib,
                year: this.annee
            }
            openModal(UpdateContribModal, props)
        }
    }
}
</script>

<style lang="css" scoped>
.sub-menu{
    height: 5vh;
    
}

@media screen and (max-width: 769px) {
    .sub-menu{
    height: 22vh;
}
.md-h4{
    display: none;
}
.banner-total-zone{
    margin-top:12px
}

}
@media screen and (min-width: 769px) {
    .sm-h4{
        display: none !important;
    }
}
</style>