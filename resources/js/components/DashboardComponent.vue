<template>
  <component :is="currentComponent"></component>
</template>

<script>
import axios from 'axios'

import 'vue3-toastify/dist/index.css';
import UserManager from './dashboard/UserManager.vue';
export default {
    components: {
        UserManager
    },
    mounted() {
        axios.post("api/get-cities", {})
            .then(res => this.cities = res.data)
        axios.get("api/get-users", {})
            .then(res => this.users = res.data)

        EventBus.$on("load-component", data=>{
            this.loadComponent(data)
        })
    },
    data() {
        return {
            currentComponent: 'UserManager'
        }
    },
    methods: {
        loadComponent(componentName){
            
        }
    }
}
</script>

<style scoped>

</style>