<template>

<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Pendaftaran Pekan Beasiswa Tunas Bertumbuh 3.0</h3>
                </div>
                <div class="card-body">
                    <form @submit.prevent="createData()">
                    <table class="table table-striped">
                      <tbody>
                          <tr>
                            <th>Nama</th>
                            <td>
                                <input v-model="name" type="text" name="name" class="form-control" placeholder="Nama" aria-label="title" aria-describedby="basic-addon1" required/>
                            </td>
                          </tr>
                          <tr>
                            <th>Jenis Kelamin</th>
                            <td>
                                <select class='form-control' v-model='gender' required>
                                    <option value='1'>Laki-Laki</option>
                                    <option value='2'>Perempuan</option>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <th>Email</th>
                            <td>
                                <input v-model="email" type="email" name="email" class="form-control" placeholder="Email" aria-label="title" aria-describedby="basic-addon1" required/>
                            </td>
                          </tr>
                          <tr>
                            <th>No WhatsApp</th>
                            <td>
                                <input v-model="phone" type="number" name="phone" class="form-control" placeholder="No WhatsApp" aria-label="title" aria-describedby="basic-addon1" required/>
                            </td>
                          </tr>
                          <tr>
                            <th>Asal Instansi</th>
                            <td>
                                <input v-model="instansi" type="text" name="instansi" class="form-control" placeholder="Asal Instansi" aria-label="title" aria-describedby="basic-addon1"/>
                            </td>
                          </tr>

                          <tr>
                            <th>Sesi Pekan Beasiswa</th>
                            <td>
                                <Multiselect
                                    v-model="sesi"
                                    mode="tags"
                                    :close-on-select="false"
                                    :searchable="true"
                                    :create-option="true"
                                    :options="sesipb"
                                  />
                            </td>
                          </tr>
                          <tr>
                            <th>Screenshot Follow Instagram Tunas Bertumbuh</th>
                            <td>
                              <div class="input-group">
                                  <el-upload
                                      ref="upload1"
                                      action="/"
                                      list-type="picture-card"
                                      :limit= 1
                                      :on-preview="handlePictureCardPreview1"
                                      :auto-upload="false"
                                      :on-exceed="handleExceed1"
                                      :on-change="updateImage1"
                                      :on-remove="handleRemove1"
                                      >
                                      <i class="el-icon-plus"></i>
                                  </el-upload>
                                  <el-dialog v-model="dialogVisible1">
                                      <img width="100%" :src="dialogImageUrl1" alt=""/>
                                  </el-dialog>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>Screenshot like postingan Pekan Beasiswa</th>
                            <td>
                              <div class="input-group">
                                  <el-upload
                                      ref="upload2"
                                      action="/"
                                      list-type="picture-card"
                                      :limit= 1
                                      :on-preview="handlePictureCardPreview2"
                                      :auto-upload="false"
                                      :on-exceed="handleExceed2"
                                      :on-change="updateImage2"
                                      :on-remove="handleRemove2"
                                      >
                                      <i class="el-icon-plus"></i>
                                  </el-upload>
                                  <el-dialog v-model="dialogVisible2">
                                      <img width="100%" :src="dialogImageUrl2" alt=""/>
                                  </el-dialog>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>Screenshot like fanpage facebook Tunas Bertumbuh</th>
                            <td>
                              <div class="input-group">
                                  <el-upload
                                      ref="upload3"
                                      action="/"
                                      list-type="picture-card"
                                      :limit= 1
                                      :on-preview="handlePictureCardPreview3"
                                      :auto-upload="false"
                                      :on-exceed="handleExceed3"
                                      :on-change="updateImage3"
                                      :on-remove="handleRemove3"
                                      >
                                      <i class="el-icon-plus"></i>
                                  </el-upload>
                                  <el-dialog v-model="dialogVisible3">
                                      <img width="100%" :src="dialogImageUrl3" alt=""/>
                                  </el-dialog>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>Mengetahui Pekan Beasiswa dari</th>
                            <td>
                                <select class='form-control' v-model='info' required>
                                    <option value='1'>Teman</option>
                                    <option value='2'>Instagram Tunas Bertumbuh</option>
                                    <option value='3'>Facebook Tunas Bertumbuh</option>
                                    <option value='4'>LinkedIn Tunas Bertumbuh</option>
                                    <option value='5'>Media Partner Tunas Bertumbuh</option>
                                    <option value='6'>Website Tunas Bertumbuh</option>
                                    <option value='7'>Lainnya</option>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <th></th>
                            <td>
                              <button type="submit" class="btn btn-primary">Save changes</button>
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
import Multiselect from '@vueform/multiselect'
import Navbar from '../components/Navbar';

export default {
  components: {
    Navbar, Multiselect,
    },

    data() {
      return {
        sesipb:[],     
        name:'',
        gender:'',
        email:'',
        phone:'',
        instansi:'',
        sesi:[],
        info:'',   
        dialogImageUrl1: '',
        dialogVisible1: false,
        imageUpload1:[],
        dialogImageUrl2: '',
        dialogVisible2: false,
        imageUpload2:[],
        dialogImageUrl3: '',
        dialogVisible3: false,
        imageUpload3:[],
      }
    },

    mounted(){
        this.getData();
    },

    methods: {
        getData() {
            console.log('A')
            axios.get('/api/pekanbeasiswa')
            .then((response)=>{
                this.$nextTick(function() {
                    for(let i = 0; i < response.data.length; i++){
                      this.sesipb.push(
                          {value: response.data[i].id, 
                            label: response.data[i].name +", "+response.data[i].detail_waktu 
                          })
                    }
                })
            })
            .catch(({ response }) => {
                console.log(response)
            })
        },

        createData(){

            const formData = new FormData()
            formData.append('name', this.name)
            formData.append('gender', this.gender)
            formData.append('email', this.email)
            formData.append('phone', this.phone)
            formData.append('instansi', this.instansi)
            formData.append('sesi', this.sesi)
            formData.append('info', this.info)
            formData.append('ssfollow',this.imageUpload1.raw)
            formData.append('sslikeig',this.imageUpload2.raw)
            formData.append('sslikefb',this.imageUpload3.raw)

            axios.post('/api/pekanbeasiswa', formData,{
                headers:{'Content-Type':'multipart/form-data'}
            })
            .then((response) => {
               $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Pendaftaran peserta pekan beasiswa telah berhasil'
                })
                this.$router.go(0);
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

        handlePictureCardPreview1(file) {
          this.dialogImageUrl1 = file.url
          this.dialogVisible1 = true
          this.imageUpload1=file
        },

        updateImage1 (file,fileList) {
          this.imageUpload1=file
        },

        handleRemove1 (file,fileList){
          this.imageUpload1 = [];
        },

        handleExceed1(){
          this.$message.error("Anda hanya diperbolehkan upload 1 gambar proyek");
          return false;
        },


        handlePictureCardPreview2(file) {
          this.dialogImageUrl2 = file.url
          this.dialogVisible2 = true
          this.imageUpload2=file
        },

        updateImage2 (file,fileList) {
          this.imageUpload2=file
        },

        handleRemove2 (file,fileList){
          this.imageUpload2 = [];
        },

        handleExceed2(){
          this.$message.error("Anda hanya diperbolehkan upload 1 gambar proyek");
          return false;
        },


        handlePictureCardPreview3(file) {
          this.dialogImageUrl3 = file.url
          this.dialogVisible3 = true
          this.imageUpload3=file
        },

        updateImage3 (file,fileList) {
          this.imageUpload3=file
        },

        handleRemove3 (file,fileList){
          this.imageUpload3 = [];
        },

        handleExceed3(){
          this.$message.error("Anda hanya diperbolehkan upload 1 gambar proyek");
          return false;
        },
    },
};

</script>

<style src="@vueform/multiselect/themes/default.css"></style>
