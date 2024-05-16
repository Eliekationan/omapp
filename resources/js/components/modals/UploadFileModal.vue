<template>
  <div class="contrib-modal" style="">
    <div class="modal-title text-center fw-bold" style="font-size: x-large;
        color: white;
        border-radius: 5px;
        background-color: #4f99ad;">Outil d'upload de fichier</div>

        <div class="modal-content p-4">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Uploader</button>
              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Fichiés uploadés</button>
              <!-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button> -->
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <br>
              <input type="file" id="input-file" style="display: none;" @change="handleFiles" name="files[]" multiple>
              <div class="col-12" style="cursor: pointer;" >
                <label for="input-file" class="drop-zone d-flex align-items-center justify-content-center"
                style="cursor: pointer;"
                @dragover.prevent @dragenter.prevent @drop="handleDrop">
                  drag and drop 
                </label>
              </div>
              <br>
              <div class="row mx-2" style="height: 300px; overflow-y: auto; overflow-x: hidden;" v-if="filesToUpload.length>0">
                <span class="fw-bold mx-2">{{ filesToUpload.length + ' fichiers trouvés' }}</span>
                <div v-for="file, index in filesToUpload" :key="index"
                class="d-md-flex align-items-center border border-1 border-black p-2 rounded mb-3">
                    <div class="col-md-2">
                      <div class="border border-2 rounded d-flex align-items-center justify-content-center text-uppercase"
                       style="height: 150px;">{{file.ext }}</div>
                    </div>
                    <div class="col-md-8" style="margin-left: 10px;">
                      <div class="card-body">
                        <h5 class="card-title">
                          <div v-if="!editMode" @click="handleEditMode()"><b>{{file.file_name}}</b></div>
                          <input type="text" v-if="editMode" v-model="file.file_name" style="font-size: 14px; margin-bottom: 10px;" @change="handleChange(file)">
                        </h5>
                        <p v-if="editModeDes" class="card-text" @dblclick="editModeDes = !editModeDes"><i>{{ file.description }}</i></p>
                        <div v-if="!editModeDes" >
                          <label for="" style="color: #4f99ad;"><i>[Veuillez saisir la description de l'image]</i></label>
                          <textarea v-model="file.description" @change="handleChangeDes(file)"
                          class="form-control"
                           style="width: 100%;" name="" id="" rows="1"></textarea>
                        </div>
                        <!-- <p class="card-text"><i>This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</i></p> -->
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                      </div>
                    </div>
                </div>
                <progress-bar />
                <div style="width: 100%; height: 10px; border: #4f99ad 1px solid">

                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
            <!-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div> -->
          </div>
        </div>
        <div class="d-flex justify-content-center my-2">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mx-4" @click="close()">Fermer</button>
                <button type="button" class="btn btn-primary" @click="saveFiles">Envoyer</button>
            </div>
        </div>
  </div>
</template>

<script>
import {closeModal} from "jenesius-vue-modal"
import { toast } from 'vue3-toastify';
import { ref } from 'vue'
import { ProgressBar } from 'vue3-progress-bar'
import Auth from '../../services/auth.js'
import { message } from "laravel-mix/src/Log";
export default {
  name: "uploadFileModal",
  inject: ["EventBus"],
  components:{
    ProgressBar
  },
  props: {
      
  },
  computed:{
      
  },

  data() {
      return {
        filesToUpload: [],
        editMode: false,
        editModeDes: false,
        authUser:"",
      }
  },
  mounted() {
    this.authUserData();
  },
  methods: {
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
    handleChange(file){
      if(["", null, undefined].includes(file.file_name)){
        toast("le nom du fichier ne peut etre vide")
        return
      }
      this.editMode = !this.editMode
    },
    handleChangeDes(file){
      if(["", null, undefined].includes(file.description)  ){
        toast("la description du fichier ne peut etre vide")
        return
      }
      this.editModeDes = !this.editModeDes
    },
    handleEditMode(){
      this.editMode = !this.editMode
    },
    close(){
        closeModal()
    },
    handleDrop(event) {
      console.log({event})
      event.preventDefault();
      const files = event.dataTransfer.files;
      this.uploadFiles(files);
    },
    handleFiles(event){
      this.filesToUpload = [...event.target.files]
      console.log({filesToUpload: this.filesToUpload})
      
      this.filesToUpload = this.filesToUpload.map(el=> {
         return {
          file: el, 
          file_name:el.name,
          description:'', 
          ext: el.type.split("/")[1],
          user_id: this.authUser.id,
          is_sent: false
        }})
      // this.saveFiles(this.filesToUpload)
    },
    uploadFiles(files) {
      // Handle file upload logic here
      // For example, you can use FileReader to read file content or use FormData to send files to a server
      const data = new FormData()
                
      console.log(files);
    },
    saveFiles(){
      const files = this.filesToUpload
      for(const file of files){
        const data = new FormData()
        data.append('user_id', this.authUser.id)
        data.append('file_name', file.file_name)
        data.append('file_url', file.file)
        data.append('file_ext', file.ext)
        data.append('description', file.description)
        axios.post("/api/upload-files",data, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).
        then(res=>{
          toast(res.data.message)
          console.log("res", res)
        })
        .catch(err=>{
            console.log("error", err)
        })
      }
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
.drop-zone{
  /* width: 80%; */
  border: 2px dotted gray;
  height: 80px;
  position: center;
}
.drop-zone:hover{
  /* width: 80%; */
  border: 2px dotted gray;
  height: 80px;
  position: center;
  transform: scaleY(1.1);
  animation: animateBorder 2s linear infinite;
}
@keyframes animateBorder {
    0% {
        border-color: #4c4c63; /* Début de l'animation - couleur rouge */
    }
    50% {
        border-color: #7edef9; /* Milieu de l'animation - couleur jaune */
    }
    100% {
        border-color: #9b9b9b; /* Fin de l'animation - couleur bleue */
    }
}
</style>