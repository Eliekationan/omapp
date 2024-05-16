import axios from 'axios';
// window.$ = window.jQuery = require('jquery/dist/jquery');
class Auth {
    constructor () {
      this.dashboardData = null
    }
    loadUserData(){
       return new Promise((resolve, reject) => {
           axios
               // .post('/api/user/dashboard', {})
               .post('/api/user/dashboard2', {})
               .then(res => {
                   resolve(res)
               })
               .catch(err => reject(err))
       })
    }
    logout(){
        console.log("ici")
       return new Promise((resolve, reject) => {
           axios.post('/api/deconnexion', {
            //    "_token": $('meta[name="csrf-token"]').attr('content')
           })
               .then(res => {
                   resolve(res)
               })
               .catch(err => reject(err))
       })
    }
}
export default new Auth();
