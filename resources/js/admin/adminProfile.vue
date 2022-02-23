<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Profile Member</h3>       
                </div>
                <div class="card-body">
                    <form @submit.prevent="updateData()">
                        <table class="table table-striped"  v-if="data.member">
                            <tbody>
                                <tr>
                                  <th>Nama</th>
                                  <td>
                                        <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Nama" aria-label="title" aria-describedby="basic-addon1" required :disabled="!isEditMode"/>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Email</th>
                                  <td>  {{data.member.email}}</td>
                                </tr>
                                <tr>
                                  <th>Foto profil</th>
                                  <td>
                                        <vue-picture-swipe :items="fileExist" v-if="!isEditMode"></vue-picture-swipe>
                                        <div class="input-group" v-else>
                                            <el-upload
                                                :ref="upload"
                                                action="/"
                                                list-type="picture-card"
                                                :limit= 1
                                                :on-preview="handlePictureCardPreview"
                                                :auto-upload="false"
                                                :on-exceed="handleExceed"
                                                :on-change="updateImage"
                                                :on-remove="handleRemove"
                                                :file-list="fileUpload"
                                                >
                                                <i class="el-icon-plus"></i>
                                            </el-upload>
                                            <el-dialog v-model="dialogVisible">
                                                <img width="100%" :src="dialogImageUrl" alt=""/>
                                            </el-dialog>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                  <th>Status</th>
                                  <td>  
                                        <small class="badge badge-success" v-if="data.member.status==1">Aktif</small>
                                        <small class="badge badge-danger" v-else>Tidak Aktif</small>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Hak Akses</th>
                                    <td v-if="data.member.permission==0">  Tidak memiliki Hak Akses admin</td>
                                        <td v-else-if="data.member.permission==1">  Founder / Executive Director</td>
                                        <td v-else-if="data.member.permission==2">  Admin AFD</td>
                                        <td v-else-if="data.member.permission==3">  Admin HRD</td>
                                        <td v-else-if="data.member.permission==4">  Admin MFD</td>
                                        <td v-else-if="data.member.permission==5">  Admin CPD</td>
                                        <td v-else-if="data.member.permission==6">  Admin PMD</td>
                                        <td v-else-if="data.member.permission==7">  Admin MIT</td>
                                        <td v-else>Web Development</td>
                                </tr>
                                <tr>
                                  <th>No telepon / wa</th>
                                    <td>
                                        <input v-model="form.latest_dependences.phone" type="number" name="phone" class="form-control" placeholder="No telepon / WA" aria-label="title" aria-describedby="basic-addon1" required :disabled="!isEditMode"/>
                                    </td>
                                </tr>
                                <tr>
                                  <th>Instagram</th>
                                    <td>
                                        <input v-model="form.latest_dependences.instagram" type="text" name="instagram" class="form-control" placeholder="Url akun instagram" aria-label="title" aria-describedby="basic-addon1" :disabled="!isEditMode"/>
                                    </td>
                                </tr>
                                <tr>
                                  <th>Facebook</th>                          
                                    <td>
                                        <input v-model="form.latest_dependences.facebook" type="text" name="facebook" class="form-control" placeholder="Url akun facebook" aria-label="title" aria-describedby="basic-addon1" :disabled="!isEditMode"/>
                                    </td>
                                </tr>
                                <tr>
                                  <th>Twitter</th>                          
                                    <td>
                                        <input v-model="form.latest_dependences.twitter" type="text" name="twitter" class="form-control" placeholder="Url akun twitter" aria-label="title" aria-describedby="basic-addon1" :disabled="!isEditMode"/>
                                    </td>
                                </tr>
                                <tr>
                                  <th>Testimoni</th>
                                    <td>
                                      <textarea v-model="form.latest_dependences.testimony" type="text" name="testimony" class="form-control" placeholder="Kesan pesan anda selama mengikuti acara" aria-label="testimony" aria-describedby="basic-addon1" rows="10" :disabled="!isEditMode"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Riwayat Jabatan </th>
                                    <td>
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table w-90" id="adminPositionTable" v-if="data.member">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Periode</th>
                                                            <th scope="col">Jabatan</th>
                                                            <th scope="col">Divisi</th>
                                                            <th scope="col">Ketua</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(d, index) in data.member.positions" :key="index">
                                                            <td>{{ d.periode.name }}</td>
                                                            <td>{{ d.jabatan.name }}</td>
                                                            <td>{{ d.division.name }}</td>
                                                            <td>{{ d.leader.name }}</td> 
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <td class="modal-footer d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary" v-show="isEditMode">Update</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal" v-if="isEditMode == false"  @click.prevent="editData(d)">Edit</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal" v-else  @click.prevent="editData(d)">Cancel</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
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
import { ref } from 'vue';

export default {
    components: {
        Navbar,
    },
    data() {
      return {
        data:{},
        form: new Form({
          id:'',
          name: '',
          latest_dependences:{
              phone: '',
              testimony: '',
              instagram: '',
              facebook: '',
              twitter: '',
              url_image: '',
          },          
        }),
        fileExist:[],
        fileUpload : ref([]),
        isEditMode: false,
        dialogImageUrl: '',
        dialogVisible: false,
        imageUpload:null
      }
    },

    computed: {
        auth_id(){
            return localStorage.getItem('user_id');
        },
        endpoint() {
            return `/api/profile/${this.auth_id}`;
        },
        auth_permission(){
            return localStorage.getItem("user_permission");
        },
    },

    mounted(){
        this.getData();        
        $('#adminPositionTable').DataTable({
                                    "searching": false,
                                    "paging":   false,
                                    "ordering": false,        
                                    "info":     false});
    },

    methods: {
        getData() {
            axios.get(this.endpoint, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then((response)=>{
                this.data = response.data;
                this.fileExist=[];
                this.fileUpload=ref([]);
                this.$nextTick(function() {
                    if(this.data.member.latest_dependences.url_image != null){
                        this.fileExist.push(
                            {
                              src: '../storage/images/users/'+this.data.member.latest_dependences.url_image,
                              thumbnail: '../storage/images/users/'+this.data.member.latest_dependences.url_image,
                              w: 1200,
                              h: 900
                            }
                        );
                        this.fileUpload.push(
                            {
                              name: 'gambar',
                              url: '../storage/images/users/'+this.data.member.latest_dependences.url_image,
                            }
                        );
                        this.imageUpload = this.fileUpload[0]
                    }
                    this.form.fill(this.data.member); 

                });
            });
        },

        editData(d){
            this.isEditMode = true ;
        },

        updateData(){

            const formData = new FormData()
            
            formData.append('name', this.form.name)
            formData.append('email', this.data.member.email)
            formData.append('phone', this.form.latest_dependences.phone)
            formData.append('testimony',this.form.latest_dependences.testimony)
            formData.append('instagram',this.form.latest_dependences.instagram)
            formData.append('facebook',this.form.latest_dependences.facebook)
            formData.append('twitter',this.form.latest_dependences.twitter)
            formData.append('url_image',this.imageUpload)
            formData.append('_method', 'PUT');

            axios.post(this.endpoint, formData,{
                headers:{'Content-Type':'multipart/form-data',
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                        }
            })
            .then(()=>{
                $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Profile updated successfully'
                })
                this.getData();
                this.isEditMode = false ;
            }).catch(()=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please contact web development team for details'
                });
            });
        },

        handlePictureCardPreview(file) {
          this.dialogImageUrl = file.url
          this.dialogVisible = true
          this.imageUpload=file
        },

        updateImage (file,fileList) {
          this.imageUpload=file.raw
        },

        handleRemove (file,fileList){
          this.imageUpload = null;
        },

        handleExceed(){
          this.$message.error("Anda hanya diperbolehkan upload 1 foto profil");
          return false;
        },

    },
};

</script>
