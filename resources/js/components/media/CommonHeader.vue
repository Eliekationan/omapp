<template>
  <div class="d-flex align-items-center justify-content-between my-4">
    <div class="title" style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-weight: 300;font-size: x-large;">{{ title }}</div>
    <div class="input-group" style="width: 300px;">
        <input type="text" class="form-control" placeholder="Search" aria-label="Search"
            aria-describedby="basic-addon2">
        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
    </div>
    <div class="" title="Ajouter des images">
        <button class="btn border border-2" @click="performAction()">
            <i class="bi bi-arrow-bar-down" style="font-size: 20px;"></i> Uploader des images
        </button>
    </div>
  </div>
</template>

<script>
import UploadFileModal from '../modals/UploadFileModal.vue'
// import { toast } from 'vue3-toastify';
import { openModal } from 'jenesius-vue-modal';
import 'vue3-toastify/dist/index.css';

export default {
    name:"common-hearder",
    props:{
        title:String
    },
    components:{
        UploadFileModal
    },
    methods:{
        performAction(){
            const props = {
                // title: `Modification de l'utilisateur ${user.name}`,
                // userData: user,
                // cities: this.cities,
                // roles: this.roles
            }
            openModal(UploadFileModal, props)
        }
    }
}
</script>

<style>

</style>