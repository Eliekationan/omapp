<template>
    <div class="card-body">
        <div class="mb-2 d-md-flex align-items-center justify-content-between sub-menu">
            <div class="title d-md-flex align-items-center">
                <h4 class="md-h4 mb-0 fw-bold text-uppercase mx-2" style="color: grey;">Cotisation annuelle de</h4>
                <div class="d-flex">
                    <h4 class="sm-h4 mb-0 fw-bold text-uppercase mx-2" style="color: grey;">Cotisation annuelle de</h4>
                    <input class="form-control" v-model="annee" type="text" placeholder="Année" @change="getContributions">
                </div>
                <div>
                    <span>Somme total encaisée: <span style="color:red; text-decoration: underline">{{ totalPerYear }} XOF</span></span>
                </div>
            </div>
            <div class="d-md-flex align-items-center">
                <i @click="getContributions" class="bi bi-arrow-clockwise" title="Recharger la page" style="font-size: 20px; cursor: pointer;"></i>
                <div class="input-group">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="search" placeholder="Search" id="form1" class="form-control" v-model="searchModel"/>
                    </div>
                    <button @click="searchContribUser()" type="button" class="btn btn-primary" data-mdb-ripple-init>
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <!-- <button title="Ajouter une nouvelle cotisation" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="bi bi-plus" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </div>
        <div class="card-content table-responsive" style="overflow-y: auto;">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prenons</th>
                        <th>Janv</th>
                        <th>Fev</th>
                        <th>Mars</th>
                        <th>Avr</th>
                        <th>Mai</th>
                        <th>Juin</th>
                        <th>Juil</th>
                        <th>Août</th>
                        <th>Sept</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        <th class="total">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in lines.data" :key="index + 'dfg'" style="cursor: pointer;" @click="openContributionModal(user)">
                        <td>{{ user?.name }}</td>
                        <td>{{ user?.second_name }}</td>
                        <td :class="{ 'bg-success': Number(contrib.amount) != 0, 'bg-danger': Number(contrib.amount) == 0 }"
                            v-for="(contrib, index) in user?.contributions" :key="index + 'li0'">{{ contrib?.amount }}
                        </td>

                        <td class="text-end text-white fw-bold"
                            style="vertical-align: middle; background-color:orange;">
                            {{ getTotal(user) }}
                        </td>
                    </tr>
                    <br>
                    <tr>
                        <!-- #a9a9a9 -->
                        <td style="background-color: black" class="text-end text-white" colspan="2">Total</td>
                        <td style="background-color: black" class="text-end text-white"  colspan="13">{{totalPerYear}} XOF</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item" style="cursor: pointer;" v-for="(link, index) in lines.links"
                            :key="index + 'rf'">
                            <span class="page-link" :class="{ 'active': link.active, 'disabled': index == 1 }"
                                @click="previousPage()" v-if="index == 0">{{ link.label.split(';')[1] }}</span>
                            <span class="page-link" :class="{ 'active': link.active }" @click="gotoPage(link.url)"
                                v-if="index > 0 && index < lines?.links?.length - 1">{{ link.label }}</span>
                            <span class="page-link"
                                :class="{ 'active': link.active, 'disabled': index == lines.last_page }"
                                @click="nextData()" v-if="index == lines?.links?.length - 1">{{ link.label.split('&')[0]}}</span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import UpdateContribModal from '../modals/UpdateContribModal.vue'
import axios from 'axios'

import { toast } from 'vue3-toastify';
import { openModal } from 'jenesius-vue-modal';
import 'vue3-toastify/dist/index.css';
export default {
    inject: ["EventBus"],
    components:{
        UpdateContribModal
    },
    computed:{
        
    },
    mounted() {
        this.getContributions()
        this.someTotalOfYear()
        this.EventBus.on("reload-contrib", this.getContributions());
    },
    data() {
        return {
            users: [],
            lines: [],
            annee: 2024,
            searchModel:"",
            totalPerYear:0
        }
    },
    methods: {
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
        getTotal(user) {
            // console.log('user', user)
            const total = user?.contributions?.reduce(
                (accumulator, el) => accumulator + Number(el.amount), 0,);
            return total
        },
        getContributions() {
            const year = this.annee
            axios.get(`/api/get-contribution/${year}`)
                .then((res) => {
                    if (!res.data?.is_success) {
                        toast(res.data.message, { autoClose: 5000 })
                        return
                    }
                    else {
                        this.reformatData(res)
                    }

                })
        this.someTotalOfYear()
        },
        reformatData(res) {
            this.lines = res.data.contribs

            this.users = [...this.lines.data]
            try {

                for (const user of this.users) {
                    let cont = []
                    let contrib = []
                    for (let index = 1; index <= 12; index++) {
                        const element = {
                            amount: 0,
                            created_at: null,
                            id: null,
                            month: index,
                            updated_at: null,
                            user_id: null,
                            year: null
                        };
                        contrib.push(element)
                    }
                    cont = contrib.map((e, k) => {
                        if (user?.contributions?.length) {
                            user?.contributions.forEach(el => {
                                
                                if (el.month == k + 1 && user.id == el.user_id) {
                                    e.amount = el.amount
                                    e.month = el.month
                                    e.user_id = el.user_id
                                }
                                
                                
                            });
                        }
                        return e
                    })
                    user.contributions = [...cont]
                }


            } catch (error) {
            }
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
    height: 10vh;
}
.md-h4{
    display: none;
}

}
@media screen and (min-width: 769px) {
    .sm-h4{
        display: none !important;
    }
}
</style>