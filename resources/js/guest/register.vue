<template>
<div>
  <Navbar/>
    <div class="container pt-5 mh-100 login-container">
        <h3 class="text-start mt-2 mb-2">Bergabung dengan Tunas Bertumbuh !</h3>
        <div class="col-md-12 p-0 no-gutters">
            <div class="mb-3 container">
                <div class="row">
                    <div class="col-lg pl-0">
                        <label for="exampleFormControlInput2" class="form-label">First name</label>
                        <input
                            type="text"
                            name="firstName"
                            class="form-control "
                            id="exampleFirstName"
                            aria-describedby="firstNameHelp"
                            placeholder="Enter your first name"
                            v-model="form.firstName"
                            :disabled="disableForm"
                        />
                        <div v-show="firstNameError" class="pl-1">
                            <p class="text-danger">
                                {{ firstNameError }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg p-0">
                        <label for="exampleFormControlInput2" class="form-label">Last name</label>
                        <input
                            type="text"
                            name="lastName"
                            class="form-control"
                            id="exampleInputLastName"
                            aria-describedby="lastNameHelp"
                            placeholder="Enter your last name"
                            v-model="form.lastName"
                            :disabled="disableForm"
                        />
                        <div v-show="lastNameError" class="pl-1">
                            <p class="text-danger">
                                {{ lastNameError }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
            <button @click="register_user" class="btn btn-success mt-1" :disabled="disableButton">
                Bergabung sekarang !
            </button>
            <button @click="resetForm" class="btn btn-warning mt-1 ml-3" :disabled="disableButton">
                Reset Input
            </button>
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
                form: {
                    email: '',
                    password: '',
                    lastName: '',
                    firstName: '',
                },

                disableForm: false,
                disableButton: false,

                emailError : null,
                firstNameError: null,
                lastNameError : null,
                passwordError : null,
            }
        },
        methods: {
            register_user() 
            {
                this.disableForm = true;
                this.disableButton = true;

                // reset all error values
                this.emailError =  null;
                this.firstNameError = null;
                this.lastNameError =  null;
                this.passwordError =  null;

                // validasi email
                if(this.form.email == '' || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.form.email))) {
                    this.emailError = "Email kurang tepat atau harap diisi kembali";
                    // enable all inputs
                    this.disableForm = false;
                    this.disableButton = false;
                }

                // validasi password
                if(this.form.password == '') {
                    this.passwordError = "Password tidak boleh kosong";
                    // enable all inputs
                    this.disableForm = false;
                    this.disableButton = false;
                }

                // validasi nama depan
                if(this.form.firstName == '') {
                    this.firstNameError = "Nama depan tidak boleh kosong";
                    // enable all inputs
                    this.disableForm = false;
                    this.disableButton = false;
                }

                // validasi nama belakang
                if(this.form.lastName == '') {
                    this.lastNameError = "Nama belakang tidak boleh kosong";
                    // enable all inputs
                    this.disableForm = false;
                    this.disableButton = false;
                }

                if(this.passwordError == null && 
                   this.emailError == null && 
                   this.firstNameError == null && 
                   this.lastNameError == null)
                {
                    axios
                    .post("/api/register", this.form)
                    .then((result) => {
                        swal.fire({
                            title: "Success",
                            text: result.data.message,
                            icon: 'success',
                        })

                        this.$router.push({
                            path:"/login",
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
                }
            },
            resetForm() {
                this.form.firstName = '';
                this.form.lastName = '';
                this.form.email = '';
                this.form.password = '';
            },
        },
    }
</script>