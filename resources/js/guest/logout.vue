<template>
<div>
  <Navbar/>
    <div class="container pt-5 mh-100 login-container">
        <h3 class="text-center mt-2 mb-2">Keluar</h3>
        <p class="text-center">Yakin anda ingin keluar ?</p>

        <div class="justify-content-center align-items-center d-flex">
            <button class="m-2 btn btn-danger" @click="logout">Log out</button>
            <button class="m-2 btn btn-warning" @click="home">Go back</button>
        </div>
    </div>
</div>
</template>

<script>
import Navbar from '../components/Navbar';

export default {
  components: {
    Navbar,},
        data() {
            return {
                disableForm: false,
                disableButton: false,
            }
        },
        methods: {
            logout() 
            {
                axios
                .post("/api/logout", null,  {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                })
                .then((result) => {
                    swal.fire({
                        title: "Success",
                        text: result.data.message,
                        icon: 'success',
                    })

                    this.removeLocalStorage();
                    
                    this.$router.push({
                        path:"/",
                    })
                })
                .catch((error) => {
                    this.disableForm = false;
                    this.disableButton = false;

                    swal.fire({
                        title: "Failed",
                        text: error.response.data.message,
                        icon: 'warning',
                    })
                })
            },
            removeLocalStorage() {
                localStorage.removeItem("user_id");
                localStorage.removeItem("token");
                localStorage.removeItem("user_name");
                localStorage.removeItem("user_email");
                localStorage.removeItem("user_status");
                localStorage.removeItem("user_permission");
            },
        },
    }
</script>