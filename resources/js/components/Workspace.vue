<template>
  <div class="d-md-flex" style="height: calc(88%);">
    <div class="workspace-left" style="
    background-color: #373857; padding-top: 1rem;">
        <div class="w-100 row align-items-center" style="height: 80px;">
            <h3 class="" style="color: #D5F1FF;">DASHBOARD</h3>
        </div>
        <template v-if="reserveRoles.includes(authUser?.roles[0]?.role_uuid)">
        <div class="nav-item d-flex align-items-center py-2" @click="setShowSubMenuDashbord">
            <i class="icon bi bi-people-fill"></i>
            <span class="text-white" style="font-size: 20px; margin-left: 10px;">
              Membres 
            </span>
            <i class="bi bi-chevron-down text-white"></i>
        </div>
            <div class="sub-div" v-if="showSubMenuDashboard">
                <div class="item d-flex text-white" style="margin-left:10% ;" 
                 
                 @click="loadComponent('UserManager')">
                    <i class="bi bi-backpack" style=" margin-right: 5px;"></i>
                    Liste d'utilisateur
                </div>
                <div class="item d-flex text-white" style="margin-left:10% ;" 
                 @click="loadComponent('RoleManager')">
                    <i class="bi bi-backpack" style=" margin-right: 5px;"></i>
                    Rôles
                </div>
                <div class="item d-flex text-white" style="margin-left:10%;"
                @click="loadComponent('AdhesionManager')">
                    <i class="bi bi-people-fill" style=" margin-right: 5px;"></i>
                    Demande d'adhésion
                </div>
            </div>
        </template>
        <div class="nav-item d-flex text-white py-2 "  v-if="contribRoles.includes(authUser?.roles[0]?.role_uuid)" @click="loadComponent(dCurrentComponent())">
            <i class="icon bi bi bi-bank" style="font-size: 20px;"></i>
            <span class="text-white" style="font-size: 20px; margin-left: 10px;">
                Cotisations
            </span>
        </div>
        <div class="nav-item d-flex text-white py-2" v-if="reserveRoles.includes(authUser?.roles[0]?.role_uuid)" @click="loadComponent('ProjectManager')">
            <i class="icon bi bi-projector" style="font-size: 20px;"></i>
            <span class="text-white" style="font-size: 20px; margin-left: 10px;">
                Projets
            </span>
        </div>
        
        <div class="nav-item d-flex  text-white align-items-center py-2" v-if="reserveRoles.includes(authUser?.roles[0]?.role_uuid)" @click="setShowSubMenuArchive">
            <i class="bi bi-archive" style="font-size: 20px;"></i>
            <span class="text-white" style="font-size: 20px; margin-left: 10px;">
              Archive 
            </span>
            <i class="bi bi-chevron-down text-white"></i>
        </div>
        <div class="sub-div" v-if="showSubMenuArchive">
            <div class="item d-flex text-white" style="margin-left:10% ;" 
             @click="loadComponent('PhotothequeManager')">
                <i class="bi bi-images" style=" margin-right: 5px;"></i>
                Photothèque
            </div>
            <div class="item d-flex text-white" style="margin-left:10% ;" 
             @click="loadComponent('videothequeManager')">
                <i class="bi bi-film" style=" margin-right: 5px;"></i>
                Vidéothèque
            </div>
        </div>
        <div class="nav-item d-flex text-white py-2" v-if="reserveRoles.includes(authUser?.roles[0]?.role_uuid)" @click="loadComponent('FileManager')">
            <i class="bi bi-files" style="font-size: 20px;"></i>
            <span class="text-white" style="font-size: 20px; margin-left: 10px;">
                Rapports
            </span>
        </div>
        
    </div>
    <!-- <div class="workspace-center vh-100" style="background-color: #dbd8d8;"> -->
    <div class="workspace-center" style="background-color: #fff;">
        <component :is="currentComponent" :authUser="authUser"></component>
    </div>
  </div>
</template>

<script>
import 'bootstrap-icons/font/bootstrap-icons.css';
import UserManager from './dashboard/UserManager.vue';
import RoleManager from './dashboard/RoleManager.vue';
import ProjectManager from './project/ProjectManager.vue';
import AdhesionManager from './dashboard/AdhesionManager.vue';
import MonetaryContribution from './contributions/MonetaryContribution.vue';
import PhotothequeManager from './media/PhotothequeManager.vue';
import videothequeManager from './media/videothequeManager.vue';
import FileManager from './files/fileManager.vue';
import MemberHome from './membres/Home.vue';
import Auth from '../services/auth.js'
export default {
    components:{
        UserManager,
        RoleManager,
        ProjectManager,
        AdhesionManager,
        MonetaryContribution,
        PhotothequeManager,
        MemberHome,
        videothequeManager,
        FileManager
    },
    computed:{
        
    },
    async mounted(){
       await this.authUserData()
        this.currentComponent = this.dCurrentComponent()
    },
    data(){
        return {
            showSubMenuDashboard: false,
            currentComponent: null,
            showSubMenuArchive: false,
            authUser:null,
            contribRoles : [
                "25251231-807d-332b-a65a-04040fb1d8cb", 
                "bfed2c96-a9bd-4c07-91cb-b75b3c1046f0"
            ],
            reserveRoles:[
                "bfed2c96-a9bd-4c07-91cb-b75b3c1046f0"
            ]
        }
    },
    methods:{
        dCurrentComponent(){
            if(this.authUser != null){
                console.log("this.authUser" ,this.authUser)
                if(this.reserveRoles.includes(this.authUser.roles[0].role_uuid)){
                    return "UserManager"
                }

                if(this.contribRoles.includes(this.authUser.roles[0].role_uuid)){
                    if(this.authUser.roles[0].role_uuid == "25251231-807d-332b-a65a-04040fb1d8cb"){
                        return "MemberHome"
                    }
                    else{
                        return "MonetaryContribution"
                    }
                }
            }
        },
        async authUserData() {
        await Auth.loadUserData()
          .then((res) => {
            this.authUser = res.data;
            // this.categorieClient = res.data.categorie_client;
          })
          .catch((err) => {
            console.log(err);
          });
      },
        setShowSubMenuDashbord(){
            this.showSubMenuDashboard = !this.showSubMenuDashboard
        },
        setShowSubMenuArchive(){
            this.showSubMenuArchive = !this.showSubMenuArchive
        },
        loadComponent(componentName){
            console.log("componentName", componentName)
            let roles = this.authUser.roles
            if(this.contribRoles.includes(roles[0].role_uuid)){
                this.currentComponent = componentName;
                // if (componentName === ''){
                // }
                // return
            }
            if (componentName === 'UserManager') {
                this.currentComponent = UserManager;
            } else if (componentName === 'RoleManager') {
                this.currentComponent = RoleManager;
            }
            else if (componentName === 'ProjectManager') {
                this.currentComponent = ProjectManager;
            }
            else if (componentName === 'AdhesionManager') {
                this.currentComponent = AdhesionManager;
            }
            else if (componentName === 'MonetaryContribution'){
                this.currentComponent = MonetaryContribution;
            }
            else if (componentName === 'PhotothequeManager'){
                this.currentComponent = "PhotothequeManager"
            }
            else if(componentName === 'videothequeManager'){
                this.currentComponent = "videothequeManager"
            }
            else if(componentName === 'FileManager'){
                this.currentComponent = 'FileManager'
            }
        }
    }
}
</script>

<style scoped>
.workspace-left{
    width: 15%;
    padding:10px;
}
.workspace-center{
    width: 85%;
    padding:10px;
}
span{
    /* text-decoration: none; */
    color:white;
    /* font-family: 'Times New Roman', Times, serif; */
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    cursor: pointer;
}
a{
    text-decoration: none;
}
.nav-item{
    cursor: pointer;
}
.icon{
    display: inline;
    font-size: 20px;
    color:white
}
@media screen and (max-width:1160px){
    .icon{
        display: none;
        color: brown;
    }
}
@media screen and (max-width:1065px) {
    .workspace-left{
        display:none;
    }
    .workspace-center{
        width: 100%;
        overflow-y: auto;
    }
}
.sub-div .item{
    cursor: pointer;
}
.item{
    margin-top: 10px;
}
</style>