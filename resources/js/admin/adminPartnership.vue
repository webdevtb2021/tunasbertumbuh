<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Data Partnership</h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                          <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click.prevent="showModal"><i class="fas fa-calendar-plus"></i> Add new data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminPartnershipTable" v-if="data">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Link to sosmed</th>
                                <th scope="col">Keterangan</th>
                                <th >Detail</th>
                                <th >Edit</th>
                                <th >Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in data" :key="index">
                                <td>{{ d.name }} </td>
                                <td v-if="d.category==1">Community Partner</td>
                                <td v-else>Media Partner</td>
                                <td>{{ d.url }} </td>
                                <td>{{ d.notes }} </td>
                                <td>
                                    <button class="btn btn-sm btn-link" @click.prevent="detailData(d)">
                                        <i class="fas fa-info-circle text-success"/>
                                    </button>
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
                    <h5 v-show="isFormCreateMode" class="modal-title" id="exampleModalLabel">Add new data Partnership</h5>
                    <h5 v-show="!isFormCreateMode" class="modal-title" id="exampleModalLabel">Update data Partnership</h5>
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
                                    <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Name" aria-label="name" aria-describedby="basic-addon1"/>                           
                                </div>
                            </div>
                            <div v-show="!isFormCreateMode"  class="col-4">
                                <img class="profile-user-img img-fluid img-circle"
                                   :src="'storage/images/partnerships/'+form.image"
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
                            <small id="emailHelp" class="form-text text-muted">*Jenis file harus jpeg, jpg, jpe, png.</small>
                        </div>

                        <div class="form-group">
                            <label>URL</label>
                            <input v-model="form.url" type="text" name="url" class="form-control" placeholder="URL" aria-label="url" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" v-model="form.category">
                                <option value="1">Community Partner</option>
                                <option value="2">Media Partner</option>
                            </select>
                        </div>
                        <div class="form-group">
                          <label>Keterangan</label>
                          <textarea v-model="form.notes" type="text" name="task" class="form-control" placeholder="Keterangan" aria-label="notes" aria-describedby="basic-addon1" :rows="10 "/>
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
            <!-- Modal containing dynamic form for displaying data details. -->
            <div class="modal fade" id="exampleModalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDetails" aria-hidden="true"> 
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" :key="detail.id">
                    <partnership-details :image="detail.image" :name="detail.name" :ig="detail.ig" :category="detail.category" :notes="detail.notes" header="More Info about The Partnership"></partnership-details>
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
import partnershipDetails from '../components/partnershipDetails.vue'
import Navbar from '../components/Navbar';
export default {
    components: {
    Navbar,
     partnershipDetails},

    data() {
      return {
        data:{},
        form: new Form({
          id:'',
          name: '',
          image: '',
          url: '',
          category: '',
          notes: '',
        }),
        isFormCreateMode: true,
        detail:{
            id:'',
            name: '',
            image: '',
            ig: '',
            category: '',
            notes: '',
        },
        dialogImageUrl: '',
        dialogVisible: false,
        imageUpload:null
      }
    },

    computed: {
        endpoint() {
            return `/api/adminpartnership`;
        },
    },

    mounted(){
        axios.get(this.endpoint,{
           headers: {
              'Authorization': 'Bearer ' + localStorage.getItem('token')
           }
        })
        .then((response)=>{
            this.data = response.data;
            this.$nextTick(function() {
                $('#adminPartnershipTable').DataTable();
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
                this.data = response.data;
                this.$nextTick(function() {
                    $('#adminPartnershipTable').DataTable();
                })
            })
        },

        showModal() {
            this.isFormCreateMode = true;
            this.form.reset(); // v form reset
            dialogImageUrl = ''
            dialogVisible = false
            imageUpload =null
            this.$refs['upload'].clearFiles();
            $('#exampleModal').modal('show'); 
        },

        createData(){
            const formData = new FormData()
            formData.append('name', this.form.name)
            formData.append('url', this.form.url)
            formData.append('category', this.form.category)
            formData.append('notes', this.form.notes)
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
                    title:'Data partnership created successfully'
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
            this.form.fill(d);
        },

        detailData(d){
            this.detail.id = d.id;
            this.detail.image = 'public/storage/images/partnerships/'+d.image;
            this.detail.name = d.name;
            this.detail.ig=d.url;
            this.detail.category = d.category==1 ? 'Community Partner' : 'Media Partner';
            this.detail.notes=d.notes;
            $('#exampleModalDetails').modal('show');
        },

        updateData(){
            const formData = new FormData()
            formData.append('name', this.form.name)
            formData.append('url', this.form.url)
            formData.append('category', this.form.category)
            formData.append('notes', this.form.notes)
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
                    title:'Data partnership updated successfully'
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
          this.$message.error("Anda hanya diperbolehkan upload 1 gambar partnership");
          return false;
        },
    },  
};

</script>