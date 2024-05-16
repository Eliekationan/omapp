<template>
  <div class="px-4 h-100" style="overflow-y: auto;">
    <common-header :title="'PHOTOTHEQUE'"/>
    <div class="row">
      <div class="col-3"  v-for="file, index in filesUploaded" :key="index + 'rt'">
        <div class="card" style="width: 18rem;">
          {{ file.file_url }}
          <img :src="file.file_url" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{ file?.file_name }}</h5>
            <p class="card-text">{{ file.description }}</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
        <!-- <div class="card-zone" style="position: relative;">
          <div class="card-body" >
            <img width="490" height="300" :src="'images/image'+i+'.jpeg'" alt="" srcset="">
          </div>
          <div class="card-footer">nslkdnj</div>
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CommonHeader from './CommonHeader.vue';
import Auth from '../../services/auth.js'
export default {
  components:{
    CommonHeader
  },
  data(){
    return {
      authUser: null,
      filesUploaded:[]
    }
  },
  async mounted(){
    await this.authUserData()
    this.getFiles()
  },
  methods:{
    async authUserData() {
        await Auth.loadUserData()
          .then((res) => {
            this.authUser = res.data;
          })
          .catch((err) => {
            console.log(err);
          });
      },
    getFiles(){
      axios.post("/api/get-files", {user_id: this.authUser.id}).then(
        res=> this.filesUploaded = res.data.files
      ).catch(err=>console.log(err))
    }
  }
}
</script>

<style>
.card-zone{
  border: solid 1px gray;
  box-shadow: 0px 0px 2px 0px grey;
  border-radius: 2px;
  margin: 4px;
}
</style>