<template>
    <div class="d-flex justify-content-between p-4 border border-1">
        <div>
            <input class="form-control" st type="text" placeholder="search">
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn p-2 px-2 " @click="createNewFolder()" title="Créer un nouveau dossier"
                style="background-color: aliceblue; background-color: #e5e9f2; margin-right: 12px; width: 180px;">
                <i class="bi bi-plus" style="color: black; font-size: 18px;"></i>
                <span style="margin-left: 12px; color:black">nouveau dossier</span>
            </button>
        </div>
    </div>
    <div class="" style="margin: 28px;height: 80%; overflow: auto;">
        <div>
            <span class="fw-bold text-uppercase"
                style="font-size: 22px; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Home</span>
        </div>
        <div class="my-4">
            <span class="fw-bold text-uppercase"
                style="font-size: 16px; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Liste
                des dossiers</span>
        </div>
        <div>
            <div class="row" v-if="showFolderZone">
                <div v-for="(folder, index) in folders" :key="index + 'folder'"
                @dblclick="openFolder(folder)"
                class="col-12 col-md-3 py-1">
                    <div class="border border-1 rounded py-2" style="background-color: #f5f6fa; cursor: pointer;">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-folder-fill" style="font-size: 100px; color:rgb(121 139 255)"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <template v-if="!canUpdateFolderName[index]">
                                <span style="font-size: large; margin-right: 12px;" :title="folder.folder_name">{{ folder.folder_name.length > 20 ?
                            folder.folder_name.substring(0, 20) + '...' : folder.folder_name }}</span> <i
                                    @click="canUpdateFolderNameFunction(index)" class="bi bi-pen-fill"></i>
                            </template>
                            <input type="text" v-model="folder.folder_name" v-if="canUpdateFolderName[index]" @keyup.enter="handleEnterKey(index, folder)">
                        </div>
                        <div class="dropdown d-flex justify-content-end" >
                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" @click="deleteFolder(folder)">
                                        <i class="bi bi-archive"></i>
                                        <span  style="margin-left: 12px;">Supprimer</span>
                                    </a>
                                </li>
                                <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="zone-principale d-flex" v-if="!showFolderZone">
                <div class="first-zone" style="border-right: 1px solid #e5e9f2;">
                    <div class="pb-4" style="background-color: white;">
                        <span style="font-size: 20px; color: orange; font-weight: bold">Explorateur de dossiers</span>
                    </div>
                    <div class="row"  style="background-color: white;">
                        <div class="col-12 mx-0" v-for="(folder, index) in folders" :key="index + 'folder'">
                            <div class="items d-flex align-items-center" :class="{'isCurrentFolder' : isCurrentFolder(folder)}" style="cursor: pointer;" @click="openFolder(folder)">
                                <i class="bi bi-folder-fill px-4" :class="{'isCurrentFolder' : isCurrentFolder(folder)}" style="font-size: 25px;"></i>
                                <div class="my-2 mx-2">
                                    <template v-if="!canUpdateFolderName[index]">
                                        <span style="font-size: large; margin-right: 12px;" :title="folder.folder_name">{{ folder.folder_name.length > 20 ?
                                    folder.folder_name.substring(0, 20) + '...' : folder.folder_name }}</span> 
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="">
                    </div> -->
                </div>
                <div class="second-zone">
                    <div class="pb-4" style="background-color: white;">
                        <span style="font-size: 16px; color: orange; font-weight: bold; margin-left: 20px;">Liste des fichiers du dossier {{ currentFolder.folder_name }}</span>
                    </div>
                    <div v-if="(files?.length == 0 || [undefined, null, ''].includes(files)) && !isUpload" class="d-flex justify-content-center align-items-center" style="height: 100%;">
                        <div>
                            <div class="d-flex justify-content-center">
                                <i class="bi bi-exclamation-triangle-fill" style="font-size: 50px; color: yellow;"></i>
                            </div>
                            <div>
                                <h4>Aucun fichier trouvé</h4>
                            </div>
                            <div class="d-flex justify-content-center">
                                <!-- <input type="text" name="" id="" v-model="filesToUpload"> -->
                                <input style="display: none;" type="file" id="fileInput" @change="handleFiles" accept="application/pdf">
                                <label for="fileInput" class="btn btn-primary">Ajouter un fichier</label>
                            </div>
                        </div>
                    </div>
                    <div class="" v-if="isUpload || files?.length > 0">
                        <div></div>
                        <table class="table-responsible table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom du fichier</th>
                                    <th>La description</th>
                                    <th>Visualiser</th>
                                    <th>Publication</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(file, indexF) in files" :key="indexF +'fileToUpload'">
                                    <td>
                                        {{ file.file_name }}
                                    </td>
                                    <td>
                                        {{ file.description }}
                                    </td>
                                    <td>
                                        <a @click="openPDFReaderModal(file.file_url)"><i class="bi bi-eye-fill" style="color:orange"></i></a>
                                    </td>
                                    <td>
                                        <i class="bi bi-share-fill" :style="dynamicSharedColor(file)" style="cursor:pointer" @click="shareFile(file)"></i>
                                    </td>
                                    <td>
                                        <input style="display: none;" type="file" id="fileInput2" @change="handleFiles" accept="application/pdf">
                                        <label for="fileInput2">
                                            <i style="cursor:pointer; color:#6576ff;" class="bi bi-file-earmark-plus-fill" v-if="indexF == files?.length - 1"></i>
                                        </label> 
                                    </td>
                                </tr>
                                <tr v-for="(file, indexF) in filesToUpload" :key="indexF +'fileToUpload'">
                                    <td>
                                        <input type="text" class="form-control" v-model="file.file_name" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="file.description" >
                                    </td>
                                    <td>
                                        <button class="btn btn-success" @click="addFile">Envoyer</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import axios from 'axios'
import Auth from '../../services/auth.js'
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';
import PDFViewer from 'pdf-viewer-vue'
import { openModal } from 'jenesius-vue-modal';
import PDFReader from '../modals/PDFReader.vue';
import ConfirmModal from '../modals/ConfirmModal.vue';
export default {
    name: "FileManger",
    props: {},
    components: {
        PDFViewer,
        PDFReader,
        ConfirmModal
    },
    mounted() {
        this.authUserData();
        this.getFolders() 
    },
    data() {
        return {
            authUser: null,
            canUpdateFolderName: {},
            filename: 'Nouveau dossier',
            folders: [],
            files: [],
            currentFolder: null,
            showFolderZone: true,
            isUpload: false,
            filesToUpload:null,
            
        }
    },
    methods: {
        dynamicSharedColor(file){
            if(file?.shared){
                return {color:'violet'}
            } 
            else{
                return {color:'red'}
            }
        },
        shareFile(file){
            const confirmShareAction = ()=>{
                const props = {
                    title: "Confirmation de la publication",
                    message: "En publiant ce fichier tous les membres du groupe pourront en avoir accès. \
                    Etes-vous sûr de vouloir le publier", 
                    share: true,
                    file
                }
                openModal(ConfirmModal, props)
            }
            confirmShareAction()
            this.getFolders() 
        },
        openPDFReaderModal(file_url){
            const props = {
                link: 'http://127.0.0.1:8090/storage/' + file_url,
                
            }
            openModal(PDFReader, props)
        },
        handleFiles(event){
            console.log({event})
            this.isUpload = true
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
        addFile(){
            const files = this.filesToUpload
            for(const file of files){
                const data = new FormData()
                data.append('upload_id', this.currentFolder.id)
                data.append('folder_id', this.currentFolder.id)
                data.append('file_name', file.file_name)
                data.append('description', file.description)
                data.append('file_url', file.file)
                data.append('file_ext', file.ext)
                data.append('upload_by', this.authUser.id)
                axios.post("/api/add-file",data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
                }).
                then(res=>{
                    toast(res.data.message)
                    console.log("res", res)
                    this.files.unshift(res.data.files)
                })
                .catch(err=>{
                    console.log("error", err)
                })
            }
            this.filesToUpload = filesToUpload
            axios.post("/api/add-file").then((res)=>{
                console.log("res==add", res.data)
                this.files = res.data.files
            })
        },
        isCurrentFolder(folder){
            if(folder.id == this.currentFolder.id){
                return true
            }
        },
        openFolder(folder){
            // this.isUpload = true
            this.showFolderZone = false
            this.currentFolder = folder
            axios.post("/api/get-files-of-folder", 
            {folder_id: folder.id}).then(res=>{
                this.files = res.data.files
                console.log("res==", res.data.files)
            })
        },
        renameFolder(folder){
            axios.post("/api/rename-folder", 
            {...folder, user_id: this.authUser.id}
            ).then(res=>{
                console.log("res", res.data)
                this.getFolders() 
                toast(res.data.message);
            })
        },
        deleteFolder(folder){
            if(folder.created_by != this.authUser.id){
               toast("Vous ne pouvez pas supprimer ce dossier")
               return 
            }
            axios.post("/api/delete-folder", 
            {user_id: this.authUser.id, folder_id: folder.id}
            ).then(res=>{
                console.log("res", res.data)
                this.getFolders() 
                toast(res.data.message);
            })
        },
        canUpdateFolderNameFunction(index){
            event.stopPropagation();
            this.canUpdateFolderName[index] = !this.canUpdateFolderName[index]
            console.log('canUpdateFolderName', this.canUpdateFolderName)
        },
        async handleEnterKey(index, folder) {
            event.stopPropagation();
            this.canUpdateFolderName[index] = false
            await this.renameFolder(folder)
            this.getFolders()

        },
        async authUserData() {
            await Auth.loadUserData()
                .then((res) => {
                    this.authUser = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        createNewFolder() {
            axios.post('/api/create-new-folder',
                { user_id: this.authUser.id }
            ).then((res) => {
                console.log('res', res)
                this.folders.unshift(res.data.newFolder)
            })
        },
        getFolders() {
            axios.post('/api/get-folders',
            ).then((res) => {
                console.log('res', res)
                this.folders = res.data.folders
            })
        }
    },
}
</script>

<style>
::-webkit-scrollbar {
    display: none; /* Largeur personnalisée */
}

/* Pour Firefox */
.centered-div {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    /* Optionally set height to center vertically */
}
.first-zone{
    width: 25%;
    background-color:#f5f6fa;
}
.second-zone{
    width: 75%;
}
.items:hover{
    /* margin-top: 20px; */
    background-color: #bfc6f8;
    
}
.isCurrentFolder{
    background-color: #6576ff;
    color: white;
}
.table{
    background-color: white !important;
}
</style>