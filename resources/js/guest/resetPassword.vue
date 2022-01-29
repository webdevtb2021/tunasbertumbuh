<template>
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

            <button type="submit" class="btn btn-success">
                Submit
            </button>
        </form>
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

export default {

	data() {
		return {
			form :  {
                email: null,
                password: null,
                password_confirmation: null,
                token: null,
            },
            formDisabled: true,
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
            if(this.form.password != this.form.password_confirmation) {
                this.formDisabled = false;
                swal.fire({
                    title: 'Warning',
                    text:   "Password doesn't match",
                    icon: 'warning',
                });
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
