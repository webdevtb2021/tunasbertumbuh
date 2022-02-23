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
                            <router-link :to="{ name: 'AdminArticle' }" class="btn btn-success">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form @submit.prevent=" id ==='create' ? createData() : updateData()">
                    <table class="table table-striped">
                      <tbody>
                            <tr>
                              <th>Judul Artikel</th>
                              <td>
                                  <input v-model="articles.title" type="text" name="title" class="form-control" placeholder="Judul Artikel" aria-label="title" aria-describedby="basic-addon1" required :disabled="isEdit != 'true'"/>
                              </td>
                            </tr>
                            <tr v-if=" id !='create'">
                              <th>Penulis</th>
                              <td v-if="articles.user">
                                  {{articles.user.name}}
                              </td>
                            </tr>
                            <tr v-if=" id !='create'">
                              <th>Tanggal ditulis</th>
                              <td>{{articles.created_at}}</td>
                            </tr>
                            <tr>
                              <th>Deskripsi</th>
                              <td>
                                  <textarea v-model="articles.body" type="text" name="description" class="form-control" placeholder="Isi artikel" aria-label="description" aria-describedby="basic-addon1"  :disabled="isEdit != 'true'" :rows="15" required/>
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
                                        :on-preview="handlePictureCardPreview"
                                        :auto-upload="false"
                                        :on-change="updateImage"
                                        :file-list="fileList"
                                        :on-remove="handleRemove"
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
        articles:{},  
        imagesList:[],
        isEdit:'',
        fileList : ref([]),
        
        dialogImageUrl: '',
        dialogVisible: false,
        imageUpload:[],
      }
    },

    computed: {
        endpoint() {
            return `/api/adminarticle/${this.id}`;
        },

        auth_id(){
            return localStorage.getItem('user_id');
        },

    },

    mounted(){
      this.getData()
    },

    methods: {
        getData() {
          this.isEdit = this.$route.query.isEdit;
          if(this.id=='create')
            console.log('A')
          else{
            axios.get(this.endpoint, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then((response)=>{
                this.articles = response.data;
                this.imagesList=[];
                this.fileList=ref([]);
                this.$nextTick(function() {
                    for(let i = 0; i < this.articles.article_images.length; i++){
                        this.imagesList.push(
                            {
                              src: '../storage/images/articles/'+this.articles.article_images[i].url_image,
                              thumbnail: '../storage/images/articles/'+this.articles.article_images[i].url_image,
                              w: 1200,
                              h: 900
                            }
                        );
                        this.fileList.push(
                            {
                              name: 'gambar'+i,
                              url: '../storage/images/articles/'+this.articles.article_images[i].url_image,
                              iid:this.articles.article_images[i].id
                            }
                        );
                    }
                })
            })            
          }
        },

        getHeader(){
            if(this.id=='create')
                return 'Tambah Artikel Baru'
            else if(this.isEdit=='true')
                return 'Update Artikel'
            else
                return 'Detail Artikel'
        },

        createData(){

            const formData = new FormData()
            formData.append('title', this.articles.title)
            formData.append('user_id', this.auth_id)
            formData.append('body', this.articles.body)
            
            for (var x = 0; x < this.imageUpload.length; x++) {
              formData.append('images['+x+']',this.imageUpload[x].raw);
            }
            axios.post('/api/adminarticle', formData,{
                headers:{'Content-Type':'multipart/form-data',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then((response) => {
               $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data Article created successfully'
                })
                this.$nextTick(function() {
                    this.$router.go({ name: 'adminarticle.show', params: { id: response.data.id }, query:{isEdit:false } })
                })
            })
            .catch(({ response }) => {
               console.log(response.data);
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
            formData.append('title', this.articles.title)
            formData.append('body', this.articles.body)
            var i = 0
            var j = 0
            for (var x = 0; x < this.imageUpload.length; x++) {
              if(this.imageUpload[x].iid != null){
                  formData.append('imagesExist['+i+']',this.imageUpload[x].iid);
                  i++;
              }
              else{
                  formData.append('images['+j+']',this.imageUpload[x].raw);
                  j++;
              }
            }
            formData.append('_method', 'PUT');

            axios.post(this.endpoint, formData,{
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
                this.$nextTick(function() {
                    this.$router.go({ name: 'adminarticle.show', params: { id: response.data.id }, query:{isEdit:false } })
                })
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

        updateImage (file, fileList){
          this.imageUpload = fileList;
        },

        handleRemove (file, fileList){
          this.imageUpload = fileList;
        },
    },
};

</script>

<style>
img[itemprop="thumbnail"] {
    width: 100px;
}
</style>
