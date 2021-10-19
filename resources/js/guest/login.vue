<template>
    <div class="container p-5">
        <h3 class="text-center mt-2 mb-5">Tunas Bertumbuh</h3>
        <div class="col-md-12">
            <form v-on:submit.prevent="login_user">
                <div class="mb-3">
                    <label for="exampleFormControlInput2" class="form-label">Enter Email</label>
                    <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" v-model="form.email">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput3" class="form-label">Enter Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPass1" aria-describedby="passHelp" placeholder="Enter Password" v-model="form.password">
                </div>
                <button type="submit" class="btn btn-primary mt-5">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {  

  data(){
    return {     
      form:{
        email: '',
        password: ''        
      }
    }
  },
  computed:{
      endpoint () {
          return `/api/login`;
      },
  }

  methods:{

     login_user(){    
        axios
        .post(this.endpoint,this.form)
        .then((res) =>{
            console.log(res["data"]["status"]);
            //reset form
            this.form.email = '';
            this.form.password = '';
            if(res["data"]["status"] == "error"){
                Swal.fire({
                    title: 'ERROR',
                    text:   "Your username and/or password are not valid",
                    icon: 'warning',
                  
                });
            }
            else{
                Swal.fire({
                    title: 'Accepted',
                    text:   "You have been logged-in successfully",
                    icon: 'success',
            
                });
            }
            
        })
        .catch((e)=>{
            console.log(e);
            Swal.fire({
                title: 'Ops',
                text:   "There is something wrong, please contact Web Development Team",
                icon: 'warning',    
            });
        })
    }
  }
}
</script>