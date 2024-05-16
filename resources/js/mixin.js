// mixin.js
import { defineComponent } from 'vue';
import axios from 'axios';

export const myMixin = defineComponent({
    mounted(){
        // this.host = process.env.HOST
    },
  data() {
    return {
      // Données partagées
      authUser:{},
      host:'http://127.0.0.1:8090'
    };
  },
  methods: {
    // Méthodes partagées
    loadAuthUserData(){
        let url = this.host + "/api/user"
        axios.get(url, {}).then(res=>{
            // console.log("res", res)
        })
        return {name: "Kationan"}
    }
  },
  computed: {
    // Propriétés calculées partagées
  },
  // Autres options de composant partagées
});