<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >{{getHeader()}}</h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                            <router-link :to="{ name: 'AdminProject' }" class="btn btn-success">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form @submit.prevent=" pid ==='create' ? createData() : updateData()">
                    <table class="table table-striped">
                      <tbody>
                            <tr>
                              <th>Judul Proyek</th>
                              <td>
                                  <input v-model="projects.title" type="text" name="title" class="form-control" placeholder="Judul Proyek" aria-label="title" aria-describedby="basic-addon1" required :disabled="isEdit != 'true'"/>
                              </td>
                            </tr>
                            <tr v-if=" id !='create'">
                              <th>Project Owner</th>
                              <td v-if="projects.user">
                                  {{projects.user.name}}
                              </td>
                            </tr>
                            <tr v-if=" pid !='create'">
                              <th>Tanggal dibuat</th>
                              <td>{{projects.created_at}}</td>
                            </tr>
                            <tr>
                              <th>Deskripsi</th>
                              <td>
                                  <textarea v-model="projects.body" type="text" name="description" class="form-control" placeholder="Isi proyek" aria-label="description" aria-describedby="basic-addon1"  :disabled="isEdit != 'true'" :rows="15" required/>
                              </td>

                            </tr>
                            <tr>
                              <th>Gambar</th>
                              <td>
                                <vue-picture-swipe :items="imagesList" v-if="isEdit != 'true'"></vue-picture-swipe>
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
                                        :file-list="fileList"
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
                              <th></th>
                              <td>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" v-if="isEdit != 'true'" @click="isEdit='true'">Edit</button>
                                <button type="submit" class="btn btn-primary" v-else>Save changes</button>
                              </td>
                            </tr>
                      </tbody>
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
import { ref } from 'vue';
import Navbar from '../components/Navbar';

export default {
    components: {
    Navbar,
     },
    props:['id'],

    data() {
      return {
        projects:{},  
        imagesList:[],
        isEdit:'',
        fileList : ref([]),
        pid:'',
        
        dialogImageUrl: '',
        dialogVisible: false,
        imageUpload:[],
      }
    },

    computed: {
        endpoint() {
            return `/api/adminproject/${this.id}`;
        },

        auth_id(){
            return localStorage.getItem('user_id');
        },


    },

    mounted(){
      this.getData(this.id)
    },

    methods: {
        getData(id) {
          this.isEdit = this.$route.query.isEdit;
          this.pid = id
          if(id=='create')
            console.log('A')
          else{
            axios.get('/api/adminproject/'+id, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then((response)=>{
                this.projects = response.data;
                this.imagesList=[];
                this.fileList=ref([]);
                this.$nextTick(function() {
                    if(this.projects.image != null){
                        this.imagesList.push(
                            {
                              src: '../storage/images/projects/'+this.projects.image,
                              thumbnail: '../storage/images/projects/'+this.projects.image,
                              w: 1200,
                              h: 900
                            }
                        );
                        this.fileList.push(
                            {
                              name: 'gambar',
                              url: '../storage/images/projects/'+this.projects.image,
                              iid:this.projects.image
                            }
                        );
                        this.imageUpload = this.fileList[0]
                    }
                })
            })            
          }
        },

        getHeader(){
            if(this.pid=='create')
                return 'Tambah Proyek Baru'
            else if(this.isEdit=='true')
                return 'Update Proyek'
            else
                return 'Detail Proyek'
        },

        createData(){

            const formData = new FormData()
            formData.append('title', this.projects.title)
            formData.append('user_id', this.auth_id)
            formData.append('body', this.projects.body)
            formData.append('image',this.imageUpload.raw)

            axios.post('/api/adminproject', formData,{
                headers:{'Content-Type':'multipart/form-data',
                          'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then((response) => {
               $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data Proyek created successfully'
                })
                this.getData(response.data.id)
                this.isEdit = 'false'
                this.pid = response.data.id
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

        updateData(){
            const formData = new FormData()
            formData.append('title', this.projects.title)
            formData.append('body', this.projects.body)
            if(this.imageUpload.iid != null){
                formData.append('imagesExist',this.imageUpload.iid);
            }
            else if(this.imageUpload.length != 0){
                formData.append('images',this.imageUpload.raw);
            }
            formData.append('_method', 'PUT');

            axios.post(this.endpoint, formData, formData,{
                headers:{'Content-Type':'multipart/form-data',
                          'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then((response)=>{
                $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Verification updated successfully'
                })
                this.getData(response.data.id)
                this.isEdit = 'false'
                this.pid = response.data.id
            }).catch(()=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please contact web development team for details'
                });
                this.isEdit=='true'
            });
        },

        handlePictureCardPreview(file) {
          this.dialogImageUrl = file.url
          this.dialogVisible = true
          this.imageUpload=file
        },

        updateImage (file,fileList) {
          this.imageUpload=file
        },

        handleRemove (file,fileList){
          this.imageUpload = [];
        },

        handleExceed(){
          this.$message.error("Anda hanya diperbolehkan upload 1 gambar proyek");
          return false;
        },
    },
};

</script>

<style>
img[itemprop="thumbnail"] {
    width: 100px;
}
</style>
