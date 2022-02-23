<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Data Merchandise</h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                          <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click.prevent="showModal"><i class="fas fa-calendar-plus"></i> Add new data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminMerchandiseTable" v-if="merchandises">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Gambar</th>
                                <th >Edit</th>
                                <th >Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in merchandises" :key="index">
                                <td>{{ d.title }} </td>
                                <td>{{ d.price }}</td>
                                <td>{{ d.description }}</td>
                                <td>
                                    <img class="profile-user-img img-fluid img-circle"
                                       :src="'storage/images/merchandises/'+d.image"
                                       alt="Merchandise">
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-link" @click.prevent="editData(d)">
                                        <i class="fas fa-edit text-warning"/>
                                    </button>
                                </td>
                                <td>
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
                    <h5 v-show="isFormCreateMode" class="modal-title" id="exampleModalLabel">Add new data Merchandise</h5>
                    <h5 v-show="!isFormCreateMode" class="modal-title" id="exampleModalLabel">Update data Merchandise</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <!-- Form for adding/updating volunteer details. When submitted call /createData() function if /isFormCreateMode value is true. Otherwise call /updateData() function. -->
                  <form @submit.prevent="isFormCreateMode ? createData() : updateData()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.title" type="text" name="name" class="form-control" placeholder="Nama merchandise" aria-label="name" aria-describedby="basic-addon1" required/>                           
                                </div>
                            </div>
                            <div v-show="!isFormCreateMode"  class="col-4">
                                <img class="profile-user-img img-fluid img-circle"
                                   :src="'storage/images/merchandises/'+form.image"
                                   alt="Merchandise">
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
                            <small id="emailHelp" class="form-text text-muted">*Jenis file harus jpeg, jpg, jpe, png.</small>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input v-model="form.price" type="number" name="price" class="form-control" placeholder="Harga" aria-label="price" aria-describedby="basic-addon1" required/>
                        </div>
                        <div class="form-group">
                          <label>Keterangan</label>
                          <textarea v-model="form.description" name="notes" class="form-control" placeholder="Keterangan" rows="4" required>
                          </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" v-show="isFormCreateMode">Save changes</button>
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
        merchandises:{},
        form: new Form({
          id:'',
          title: '',
          image: '',
          price: '',
          description: '',
        }),
        isFormCreateMode: true,
        dialogImageUrl: '',
        dialogVisible: false,
        imageUpload:null
      }
    },

    computed: {
        endpoint() {
            return `/api/adminmerchandise`;
        },
    },

    mounted(){
        axios.get(this.endpoint,{
           headers: {
              'Authorization': 'Bearer ' + localStorage.getItem('token')
           }
        })
        .then((response)=>{
            this.merchandises = response.data;
            this.$nextTick(function() {
                $('#adminMerchandiseTable').DataTable();
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
                this.merchandises = response.data;
                this.$nextTick(function() {
                    $('#adminMerchandiseTable').DataTable();
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
            formData.append('title', this.form.title)
            formData.append('price', this.form.price)
            formData.append('description', this.form.description)
            formData.append('image',this.imageUpload)

            axios.post(this.endpoint, formData,{
                headers:{'Content-Type':'multipart/form-data',
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                        }
            })
            .then(() => {
               $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data merchandise created successfully'
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
            this.form.reset(); // v form reset
            this.dialogImageUrl = ''
            this.dialogVisible = false
            this.imageUpload =null
            this.$refs['upload'].clearFiles();
            $('#exampleModal').modal('show'); 
            this.form.fill(d);
        },

        detailData(d){
            this.detail.id = d.id;
            this.detail.image = 'public/storage/images/merchandises/'+d.image;
            this.detail.price = d.price;
            this.detail.description = d.description;
            $('#exampleModalDetails').modal('show');
        },

        updateData(){
            const formData = new FormData()
            formData.append('title', this.form.title)
            formData.append('description', this.form.description)
            formData.append('price', this.form.price)
            formData.append('image',this.imageUpload)
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
                    title:'Data merchandise updated successfully'
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
          this.$message.error("Anda hanya diperbolehkan upload 1 gambar merchandise");
          return false;
        },
    },  
};

</script>
