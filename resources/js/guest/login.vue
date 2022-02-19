<template>
<div>

  <Navbar/>
    <div class="container pt-5 mh-100 login-container">
        <h3 class="text-start mt-2 mb-2">Masukkan email dan password untuk login sebagai admin</h3>
        <div class="col-md-12 p-0 no-gutters">
            
                <div class="mb-3">
                    <label for="exampleFormControlInput2" class="form-label">Email</label>
                    <input
                        type="text"
                        name="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Enter Email"
                        v-model="form.email"
						:disabled="disableForm"
                    />
					<div v-show="emailError" class="pl-1">
						<p class="text-danger">
							{{ emailError }}
						</p>
					</div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput3" class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        id="exampleInputPass1"
                        aria-describedby="passHelp"
                        placeholder="Enter Password"
                        v-model="form.password"
						:disabled="disableForm"
                    />					
					<div v-show="passwordError" class="pl-1">
						<p class="text-danger">
							{{ passwordError }}
						</p>
					</div>
                </div>
                <button @click="login_user" class="btn btn-success mt-1" :disabled="disableButton">
                    Sign In
                </button>
				<button @click="resetForm" class="btn btn-warning mt-1 ml-3" :disabled="disableButton">
                    Reset
                </button>
				<span>
					<router-link :to="{ name: 'Forgot Password' }" class="btn btn-white mt-1 ml-3">Forgot your password ?</router-link>
				</span>
        </div>
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
			form: {
				email: '',
				password: ''
			},

			disableForm: false,
			disableButton: false,

			passwordError : null,
			emailError : null,
			
			// rules
			emailRules: [
				(v) => !!v || 'E-mail tidak boleh kosong',
				v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
			],
			passwordRules: [
				(v) => !!v || 'Password tidak boleh kosong',
			],
			loginFailed: 0,
		}
	},

	computed:{
		endpoint () {
			return `/api/login`;
		},
	},

	methods:{
		login_user() 
		{
			this.disableForm = true;
			this.disableButton = true;
			this.emailError = null;
			this.passwordError = null;
			console.log(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.form.email))
			if(this.form.email == '' || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.form.email))) {
				this.emailError = "Email kurang tepat atau harap diisi kembali";
				// enable all inputs
				this.disableForm = false;
				this.disableButton = false;
				
			}
			if(this.form.password == '') {
				this.passwordError = "Password tidak boleh kosong";
				// enable all inputs
				this.disableForm = false;
				this.disableButton = false;
			}
			
			
			if(this.passwordError == null && this.emailError == null) {
				axios
				.post(this.endpoint,this.form)
				.then((res) =>{
					console.log(res.data);
					console.log(res["data"]["user"]["id"]);
					console.log(res.data.user.id);
	
					var status = res.data.status; 
	
					if(status 	== "error"){
						swal.fire({
							title: 'Error',
							text:   res.data.message,
							icon: 'warning',
	
						});
					}
					else{
	
						this.resetForm();
	
						// enable all inputs
						this.disableForm = false;
						this.disableButton = false;
	
						swal.fire({
							title: 'Accepted',
							text:   "You have been logged-in successfully",
							icon: 'success',
						});
	
						// save data to localStorage
						this.saveLocalStorage(res);
						
						// redirection
						this.redirectToPage(res);
					}
	
				})
				.catch(e => {
					console.log(e.response);
					swal.fire({
						title: 'Oops !',
						text:   e.response.data.message,
						icon: 'warning',
					});

					// tombol lupa password akan dinyalakan ketika percobaan login sudah >= 3x
					this.loginFailed++;

					// enable all inputs
					this.disableForm = false;
					this.disableButton = false;
				})
			}

		},
		resetForm () 
		{
			this.form.email = '';
			this.form.password = '';
		},
		saveLocalStorage(resultData) {
			localStorage.setItem("user_id", resultData.data.user.id);
			localStorage.setItem("token", resultData.data.access_token);
			localStorage.setItem("user_name", resultData.data.user.name);
			localStorage.setItem("user_email", resultData.data.user.email);
			localStorage.setItem("user_status", resultData.data.user.status);
			localStorage.setItem("user_permission", resultData.data.user.permission);
		},
		removeLocalStorage() {
			localStorage.removeItem("user_id");
			localStorage.removeItem("token");
			localStorage.removeItem("user_name");
			localStorage.removeItem("user_email");
			localStorage.removeItem("user_status");
			localStorage.removeItem("user_permission");
		},
		redirectToPage(resultUser) {
			if(resultUser.data.user.permission == 0) {
				// 0: Have no access admin

			}
			else if(resultUser.data.user.permission == 1) {
				// 1: all access
				this.$router.push({
					path: "/",
				})
			}
			else if(resultUser.data.user.permission == 2) {
				// 2: Web Dev
				this.$router.push({
					path: "/",
				})
			}
			else if(resultUser.data.user.permission == 3) {
				// 3: HR
				this.$router.push({
					path: "/admindivision",
				})
			}
			else if(resultUser.data.user.permission == 4) {
				// 4: Marketing and Fundraisin
				this.$router.push({
					path: "/adminfinance",
				})
			}
			else if(resultUser.data.user.permission == 5) {
				// 5: Comm and Partner
				this.$router.push({
					path: "/",
				})
			}
			else if(resultUser.data.user.permission == 6) {
				// 6: Project management
				this.$router.push({
					path: "/",
				})
			}
		},
		logout() {
			this.removeLocalStorage();
			this.$router.push({
				path: "/",
			})
		},
	}
}
</script>
