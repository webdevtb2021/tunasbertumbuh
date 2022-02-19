<template>
<div>
  <Navbar/>
    <div class="container pt-5 mh-100 login-container">
        <h3 class="text-start mt-2 mb-2">Reset Password</h3>
        
        <!-- alert kalau success -->
        <span v-if="success == true">
            <div class="alert-success alert" role="alert">
                {{ message }}
            </div>
        </span>

        <div class="form-group">
            <label for="email">Enter your previous email address</label>
            <input type="text" id="email" v-model="email" class="form-control" :disabled="disableForm">
        </div>
        <span v-if="error == true">
            <div class="alert-danger alert" role="alert">
                {{ message }}
            </div>
        </span>

        <button type="submit" @click="submitForgotPassword" class="btn btn-danger" :disabled="disableForm">
            Send password reset link
        </button>


    </div>
</div>
</template>

<!-- in file styling -->
<style>
	.login-container {
		width: 80%;
	}

	@media screen and (max-width: 576px){
		.login-container {
			width: 100%;
		}	
	}
</style>

<script>
import Navbar from '../components/Navbar';

export default {
  components: {
    Navbar,},

	data() {
		return {
			email: null,
            success:null,
            error:null,
			disableForm:false,
		}
	},

	computed:{
		endpoint () {
			return `/api/forget-password`;
		},
	},

	methods:{
		submitForgotPassword() {
			this.disableForm = true;
			
            axios
				.post(this.endpoint,{
					email : this.email
				})
				.then((res) =>{
					
					// disini mencoba mengirimkan email menggunakan Laravel Mailer

					console.log(res.data);
					
					var status = res.data.status; 
	
					if(status	== "error"){
						swal.fire({
							title: 'Error',
							text:   res.data.message,
							icon: 'warning',
						});
					}
					else{
						// kalau sukses kirim email
						swal.fire({
							title: 'Accepted',
							text:   "Email has been sent to "+this.email+". Please check your inbox/spam folder",
							icon: 'success',
						});

						// balikin ke home
						this.$router.push({
							path: "/",
						})
					}
					this.disableForm = false;
				})
				.catch(e => {
					console.log(e.response);
					this.disableForm = false;
					
					// kalau gagal, dinyatakan lewat swal dari errors() yang diberikan dari Laravel
					swal.fire({
						title: 'Oops !',
						text:   e.response.data.message,
						icon: 'warning',
					});
	
					// enable all inputs
					this.disableForm = false;
					this.disableButton = false;
				})
        },
		
	}
}
</script>
