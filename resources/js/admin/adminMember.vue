<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Data Member</h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                          <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click.prevent="showModal"><i class="fas fa-calendar-plus"></i> Add new data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminMemberTable" v-if="member">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">No handphone</th>
                                <th scope="col">Hak Akses</th>
                                <th scope="col">Status</th>
                                <th scope="col">Last Position</th>
                                <th >Detail</th>
                                <th v-if="auth_permission==3">Edit</th>
                                <th v-if="auth_permission==3">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in member" :key="index">
                                <td>{{ d.name }} </td>
                                <td>{{ d.email }}</td>
                                <td v-if="d.latest_dependences">{{ d.latest_dependences.phone }}</td>
                                <td v-else></td>
                                <td v-if="d.permission==0">Tidak memiliki Hak Akses admin</td>
                                <td v-else-if="d.permission==1">Founder / Executive Director</td>
                                <td v-else-if="d.permission==2">Admin AFD</td>
                                <td v-else-if="d.permission==3">Admin HRD</td>
                                <td v-else-if="d.permission==4">Admin MFD</td>
                                <td v-else-if="d.permission==5">Admin CPD</td>
                                <td v-else-if="d.permission==6">Admin PMD</td>
                                <td v-else-if="d.permission==7">Admin MIT</td>
                                <td v-else>Web Development</td>
                                <td>
                                    <small class="badge badge-success" v-if="d.status==1">Aktif</small>
                                    <small class="badge badge-danger" v-else>Tidak Aktif</small>
                                </td>
                                
                                <td v-if="d.latest_positions">{{ d.latest_positions.jabatan.name }} {{ d.latest_positions.division != null ? d.latest_positions.division.name :''}} {{ d.latest_positions.periode.name }}</td>
                                <td v-else></td>
                                <td>
                                    <router-link :to="{ name: 'adminmember.show', params: { id: d.id } }"  class="btn btn-sm btn-link">
                                        <i class="fas fa-info-circle text-success"/> 
                                    </router-link>
                                </td>
                                <td v-if="auth_permission==3">
                                    <button class="btn btn-sm btn-link" @click.prevent="editData(d)">
                                        <i class="fas fa-edit text-warning"/>
                                    </button>
                                </td>
                                <td v-if="auth_permission==3">
                                    <button class="btn btn-sm btn-link" @click.prevent="deleteData(d.id)">
                                        <i class="fas fa-trash  text-danger"/>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal containing dynamic form for adding/updating data details. -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <!-- Show/hide headings dynamically based on /isFormCreateMode value (true/false) -->
                    <h5 v-show="isFormCreateMode" class="modal-title" id="exampleModalLabel">Add new data Member</h5>
                    <h5 v-show="!isFormCreateMode" class="modal-title" id="exampleModalLabel">Update data Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <!-- Form for adding/updating user details. When submitted call /createData() function if /isFormCreateMode value is true. Otherwise call /updateData() function. -->
                  <form @submit.prevent="isFormCreateMode ? createData() : updateData()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Name" aria-label="name" aria-describedby="basic-addon1" required />                           
                                </div>
                            </div>
                            <div v-show="!isFormCreateMode"  class="col-4">
                                <img class="profile-user-img img-fluid img-circle" v-if="form.latest_dependences.url_image!=null" :src="'storage/images/users/'+form.latest_dependences.url_image"
                                   alt="User profile picture">
                            </div>
                        </div>                        
                        <div class="form-group">                        
                            <label for="foto">Change Image</label>
                            <div class="input-group">
                                <el-upload
                                    ref="upload"
                                    action="/"
                                    list-type="picture-card"
                                    :limit= 1
                                    :on-preview="handlePictureCardPreview"
                                    :auto-upload="false"
                                    :on-exceed="handleExceed"
                                    :on-change="updateImage"
                                    >
                                    <i class="el-icon-plus"></i>
                                </el-upload>
                                <el-dialog v-model="dialogVisible">
                                    <img width="100%" :src="dialogImageUrl" alt=""/>
                                </el-dialog>
                            </div>
                            <small id="emailHelp" class="form-text text-muted">*Jenis file harus jpeg, jpg, png.</small>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" placeholder="Email" required v-model="form.email"/> 
                        </div>
                        <div class="form-group">
                            <label>Hak Akses</label>
                            <select class="form-control" v-model="form.permission">
                                <option value="0">Tidak memiliki Hak Akses admin</option>
                                <option value="1">Founder / Executive Director</option>
                                <option value="2">Admin AFD</option>
                                <option value="3">Admin HRD</option>
                                <option value="4">Admin MFD</option>
                                <option value="5">Admin CPD</option>
                                <option value="6">Admin PMD</option>
                                <option value="7">Admin MIT</option>
                                <option value="8">Web Development</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" v-model="form.status">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputPhone">No Handphone</label>
                            <input class="form-control" id="inputPhone" type="text" placeholder="Nomor Telepon" v-model="form.latest_dependences.phone" required />
                        </div>
                        <div class="form-group">
                            <label for="inputTestimony">Testimony</label>
                            <textarea class="form-control" id="inputTestimony" placeholder="Testimony" rows="4" v-model="form.latest_dependences.testimony"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Instagram</label>
                            <input v-model="form.latest_dependences.instagram" type="text" name="instagram" class="form-control" placeholder="Link instagram" aria-label="name" aria-describedby="basic-addon1"/> 
                        </div>
                        <div class="form-group">
                            <label>Facebook</label>
                            <input v-model="form.latest_dependences.facebook" type="text" name="Facebook" class="form-control" placeholder="Link Facebook" aria-label="name" aria-describedby="basic-addon1"/> 
                        </div>
                        <div class="form-group">
                            <label>Twitter</label>
                            <input v-model="form.latest_dependences.twitter" type="text" name="twitter" class="form-control" placeholder="Link twitter" aria-label="name" aria-describedby="basic-addon1"/> 
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" v-show="isFormCreateMode">Save</button>
                      <button type="submit" class="btn btn-primary" v-show="!isFormCreateMode">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div> 
        </div>
    </div>
</div>
</template>

<script>

import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from 'jquery'; 
import Navbar from '../components/Navbar';
export default {
    components: {
    Navbar,
     },

    data() {
      return {
        member:{},
        form: new Form({
          id:'',
          name: '',
          email: '',
          status: '',
          permission: '',
          latest_dependences:{
              phone: '',
              testimony: '',
              instagram: '',
              facebook: '',
              twitter: '',
              url_image: '',
          },          
        }),
        isFormCreateMode: true,
        dialogImageUrl: '',
        dialogVisible: false,
        imageUpload:null
      }
    },

    computed: {
        endpoint() {
            return `/api/adminmember`;
        },
        auth_id(){
            return localStorage.getItem('user_id');
        },
        auth_permission(){
            return localStorage.getItem("user_permission");
        },
    },

    mounted(){
        axios.get(this.endpoint,{
           headers: {
              'Authorization': 'Bearer ' + localStorage.getItem('token')
           }
        })
        .then((response)=>{
            this.member = response.data;
            this.$nextTick(function() {
                $('#adminMemberTable').DataTable();
            })
        })
    },

    methods: {
        getData() {
            axios.get(this.endpoint,{
               headers: {
                  'Authorization': 'Bearer ' + localStorage.getItem('token')
               }
            })
            .then((response)=>{
                this.member = response.data;
                this.$nextTick(function() {
                    $('#adminMemberTable').DataTable();
                })
            })
        },

        showModal() {
            this.isFormCreateMode = true;
            this.form.reset(); // v form reset
            this.dialogImageUrl = ''
            this.dialogVisible = false
            this.imageUpload =null
            this.$refs['upload'].clearFiles();
            $('#exampleModal').modal('show'); 
        },

        createData(){
            const formData = new FormData()
            
            formData.append('name', this.form.name)
            formData.append('email', this.form.email)
            formData.append('status', this.form.status)
            formData.append('permission', this.form.permission)
            formData.append('phone', this.form.latest_dependences.phone)
            formData.append('testimony',this.form.latest_dependences.testimony)
            formData.append('instagram',this.form.latest_dependences.instagram)
            formData.append('facebook',this.form.latest_dependences.facebook)
            formData.append('twitter',this.form.latest_dependences.twitter)
            formData.append('url_image',this.imageUpload)

            axios.post(this.endpoint, formData,{
                headers:{'Content-Type':'multipart/form-data',
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                        }
            })
            .then(() => {
               $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data member created successfully'
                })
                this.getData();
            })
            .catch(({ response }) => {
               console.log(response);
               swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please contact web development team for details'
                });
            })
        },

        editData(d){
            this.isFormCreateMode=false;
            this.form.reset();
            this.form.clear();
            this.dialogImageUrl = ''
            this.dialogVisible = false
            this.imageUpload =null
            this.$refs['upload'].clearFiles();
            $('#exampleModal').modal('show'); 
            if(d.latest_dependences)
                this.form.fill(d);
            else{
                this.form.fill(d);
                this.form.latest_dependences = {
                  phone: '',
                  testimony: '',
                  instagram: '',
                  facebook: '',
                  twitter: '',
                  url_image: '',
                }        
            }
        },

        updateData(){
            const formData = new FormData()
            formData.append('name', this.form.name)
            formData.append('email', this.form.email)
            formData.append('status', this.form.status)
            formData.append('permission', this.form.permission)
            formData.append('phone', this.form.latest_dependences.phone)
            formData.append('testimony',this.form.latest_dependences.testimony)
            formData.append('instagram',this.form.latest_dependences.instagram)
            formData.append('facebook',this.form.latest_dependences.facebook)
            formData.append('twitter',this.form.latest_dependences.twitter)
            formData.append('url_image',this.imageUpload)
            formData.append('_method', 'PUT');

            axios.post(this.endpoint +'/'+ this.form.id, formData,{
                headers:{'Content-Type':'multipart/form-data',
                         'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(() => {
               $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data member updated successfully'
                })
                this.getData();
            })
            .catch(({ response }) => {
               console.log(response);
               swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please contact web development team for details'
                });
            })
        },

        deleteData(id){
            swal.fire({
                title:'Are you sure?',
                text:'This action will delete data permanently',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.value){
                    this.form.delete(this.endpoint + '/' + id,{
                                       headers: {
                                          'Authorization': 'Bearer ' + localStorage.getItem('token')
                                       }
                                    })
                    .then(()=>{
                        swal.fire('Deleted!',
                                    'Your data has been deleted',
                                    'success'
                                );
                        this.getData();
                    }).catch(()=>{
                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: 'Please contact web development team for details'
                        });
                    });
                }
            })
        },

        handlePictureCardPreview(file) {
          this.dialogImageUrl = file.url
          this.dialogVisible = true
          this.imageUpload=file
        },

        updateImage (file) {
          this.imageUpload=file.raw
        },

        handleExceed(){
          this.$message.error("Anda hanya diperbolehkan upload 1 gambar volunteer");
          return false;
        },
    },  
};

</script>
