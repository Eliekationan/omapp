<template>
  <div class="d-flex justify-content-between align-items-center px-4" style="
  background-color: #4E4E68; height: calc(12%);
  border-bottom:#A9A9A9 solid 5px; z-index: 10;">
    <div class="logo-zone d-flex align-items-center">
      <img width="70" src="images/logo.png" alt="" srcset="">
      <h2 class="enterprise-name" style="margin-left:14px; color: #B3F0E9;">Organization Manager</h2>
    </div>
    <a class="log-in-out nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <button class="btn text-white"><i class="bi bi-list"></i></button>
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <!-- <li><a class="dropdown-item" href="#">Membres</a></li> -->
            <li><a class="dropdown-item" href="#">Cotisations</a></li>
            <!-- <li><a class="dropdown-item" href="#">Projets</a></li> -->
            <li><hr class="dropdown-divider"></li>
            <li class="user-info"><a  href="#">{{ authUser?.name }} {{ authUser?.second_name }}</a></li>
              <li class="user-info"><a href="#">{{ authUser?.email }}</a></li>
              <button class=" btn border w-100 mt-4" @click="updateProfil">Mise à jour</button>
              <button class="log-out btn border w-100 mt-4 bg-grey" @click="logout">Deconnexion</button>
          </ul>
    <!-- <div class="log-in-out">
      <div class="">bla bla</div>
    </div> -->
    <div class="log-out-zone" style="position: relative;">
      <ul>
        <li class="dropdown" ref="dropdown" style="list-style: none;">
          <a class=" text-white" data-toggle="dropdown" style="text-decoration: none;" >
            <h4>{{authUser?.name}} <i class="bi bi-chevron-down"></i></h4>
            <div class="dropdown-menu dropdown-menu-end" style="position: absolute; width: 250px; margin-top:0.5rem">
              <li class="user-info"><a  href="#">{{ authUser?.name }} {{ authUser?.second_name }}</a></li>
              <li class="user-info"><a href="#">{{ authUser?.email }}</a></li>
              <button class="d-flex btn border w-100 mt-4 bg-gray" @click="updateProfil()">
                <i class="bi bi-person" style="margin-right: 20px;"></i>
                <span>Mise à jour</span>
              </button>
              <button class=" btn border w-100 mt-4 bg-grey" @click="logout">
                <i class="bi bi-power text-danger" style="margin-right: 20px;"></i>
                <span>Deconnexion</span>
              </button>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import $ from 'jquery';
import Auth from '../services/auth.js'
import { openModal } from 'jenesius-vue-modal';
import UpdateUserInfo from './modals/UpdateUserInfo.vue';
export default {
  data(){
    return {
      authUser:"",
      show_menu:false
    }
  },
  mounted(){
    $(this.$refs.dropdown).hover(function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });
    this.authUserData();
  },
  methods:{
    updateProfil(){
      const props = {
          title: `Mise à jour de votre profile`,
          user: this.authUser,
          
      }
      openModal(UpdateUserInfo, props)
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
    async logout(){
      await Auth.logout()
      .then((res)=>{
        console.log(res)
        window.location.reload()
      })
    },
    showMenu(){
      alert(0)
      this.show_menu = true
    }
  }

}
</script>

<style>
.dropdown-menu{
  /* margin-top: 60px; */
  width: 80%;
  box-shadow: 5px 4px 5px #000;
  overflow-x: auto;
  padding: 1.5rem;
}
.log-out-zone{
  width: 300px;
}
.user-info > a{
  text-decoration: none;
  font-size: 16px;
  color: black;
}
.log-out{
  border: #000 1px;
  color: white;
  /* text-align: center; */
}
.log-out:hover{
  border: #000 1px;
  color: black;
}
.bg-grey{
  background-color: #4e4e68;
}
@media screen and (max-width:1065px) {
  .log-out-zone{
    display: none;
  }
  .enterprise-name{
    display: none;
  }
}
@media screen and (min-width:1065px) {
  .log-in-out{
    display: none;
  }
}
</style>