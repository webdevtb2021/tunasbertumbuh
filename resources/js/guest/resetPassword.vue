<template>
<div>
  <Navbar/>
    <div class="container pt-5 mh-100 login-container">
        <h3 class="text-start mt-2 mb-2">Reset password</h3>
        <!-- 
            kebutuhannya
                - email yang disable, diambil dari database
                - password baru 
                - password konfimasi
                - tombol send
            cara sendnya sama, bukan pakai form tapi lewat fungsi
         -->

        <form @submit="changePassword">
            <label for="email" class="form-label">Email : </label>
            <input
                type="email"
                name="email"
                class="form-control "
                id="email"
                aria-describedby="emailHelp"
                placeholder="Your email : "
                v-model="form.email"
                :disabled="true"
                required
            />

            <label for="newPassword" class="form-label">New Password : </label>
            <input
                type="password"
                name="password"
                class="form-control "
                id="password"
                aria-describedby="newPasswordHelp"
                placeholder="Enter new password"
                v-model="form.password"
                :disabled="formDisabled"
                required
            />
            <div v-show="passwordBoolError" class="pl-1">
                <p class="text-danger">
                    {{ passwordError }}
                </p>
            </div>

            <label for="newPasswordConfirm" class="form-label">New Password Confirmation : </label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control "
                id="password_confirmation"
                aria-describedby="newPasswordConfirmHelp"
                placeholder="Confirm your new password"
                v-model="form.password_confirmation"
                :disabled="formDisabled"
                required
            />
            <div v-show="passwordBoolError" class="pl-1">
                <p class="text-danger">
                    {{ passwordConfirmationError }}
                </p>
            </div>

            <button type="submit" class="mt-2 btn btn-success">
                Submit
            </button>
        </form>
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
			form :  {
                email: null,
                password: null,
                password_confirmation: null,
                token: null,
            },
            formDisabled: true,
            passwordError : null,
            passwordBoolError: false,
            passwordConfirmationError : null,
		}
	},

	computed:{
		endpoint () {
			return `/api/reset-password`;
		},
	},
    created() {
        this.form.token = this.$route.params.token;
        axios
				.post("/api/getEmail",{
					token : this.form.token
				})
				.then((res) =>{
                    console.log("////////////////////////////////");
                    console.log(res)
                    this.form.email = res.data.message.email
                    this.formDisabled = false;
				})
				.catch(e => {
                     // arahin ke home
                    this.$router.push({
						path: "/",
					})

					swal.fire({
						title: 'Oops !',
						text:   "Token tidak ditemukan, ajukan ulang penggantian password",
						icon: 'warning',
					});
				})
    },
	methods:{
		changePassword(e) {
            e.preventDefault();
            this.formDisabled = true;
            this.passwordError = null;
            this.passwordBoolError = null;
            this.passwordConfirmationError = null;

            if(this.form.password.trim().length < 7) {
                // karena pengecekan dilakukan dengan menghilangkan spasi awal dan akhir terlebih dahulu
                // kalau password yang dimasukkan tidak memiliki karakter, maka tidak boleh login
                this.formDisabled = false;
                this.passwordBoolError = true;                
                this.passwordError = "Please fill the password correctly";
            }
            else if(this.form.password != this.form.password_confirmation) {
                // kalau password tidak sama dengan konfirmasi password
                this.passwordConfirmationError = "Password doesn't match";
                this.passwordBoolError = true;
                this.formDisabled = false;
            }
            else if(/^[a-zA-Z0-9]*$/.test(password)) {
                // password yang diperbolehkan hanya alfabet + numerik no spasi/karakter khusus
                this.formDisabled = false;
                this.passwordError = "Password should contain only alphabet and numeric characters";
                this.passwordBoolError = true;                
            }
            else {
                axios .put("/api/resetPassword",this.form)
                      .then((res) =>{
                        console.log(res);
    
                        // hapus semua local storagenya
                        this.removeLocalStorage();
    
                        // tampilkan swal
                        swal.fire({
                            title: 'Success ! Please login again',
                            text:   res.data.message,
                            icon: 'success',
                        });
                        
                        this.formDisabled = false;
    
                        // arahin ke home
                        this.$router.push({
                            path: "/",
                        })
                    })
                    .catch(e => {
                        console.log(e.response)
                        swal.fire({
                            title: 'Oops !',
                            text:   "Terjadi kesalahan, silahkan coba kembali",
                            icon: 'warning',
                        });
                        this.formDisabled = false;
                    })
            }
        },
        removeLocalStorage() {
			localStorage.removeItem("user_id");
			localStorage.removeItem("token");
			localStorage.removeItem("user_name");
			localStorage.removeItem("user_email");
			localStorage.removeItem("user_status");
			localStorage.removeItem("user_permission");
		},
	}
}
</script>
