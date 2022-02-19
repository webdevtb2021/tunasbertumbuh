<template>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Absensi Peserta Pekan Beasiswa Tunas Bertumbuh 3.0</h3>
                </div>
                <div class="card-body">
                    <form @submit.prevent="updateData()">
                    <table class="table table-striped">
                      <tbody>
                          <tr>
                            <th class="col-4">Nama</th>
                            <td>
                                <input v-model="nama" type="text" name="nama" class="form-control" placeholder="Nama saat mendaftar pekan beasiswa" aria-label="title" aria-describedby="basic-addon1" required/>
                            </td>
                          </tr>
                          <tr>
                            <th class="col-4">Email</th>
                            <td>
                                <input v-model="email" type="email" name="email" class="form-control" placeholder="Email" aria-label="title" aria-describedby="basic-addon1" required/>
                            </td>
                          </tr>
                          <tr>
                            <th>Sesi Pekan Beasiswa</th>
                            <td>
                                <select class='form-control' v-model='sesi' required>
                                    <option v-for='sesi in sesipb' :value='sesi.id'>{{sesi.name}}, {{sesi.detail_waktu}}</option>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <th>Kesan Pesan selama sesi pekan beasiswa</th>
                              <td>
                                  <textarea v-model="notes" type="text" name="description" class="form-control" placeholder="Kesan pesan anda selama mengikuti acara" aria-label="description" aria-describedby="basic-addon1" rows="10" required/>
                              </td>
                          </tr>
                          <tr>
                            <th></th>
                            <td>
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                    </form>
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
    Navbar,},

    data() {
      return {
        sesipb:[],
        nama:'',
        email:'',
        sesi:'',
        notes:'', 
      }
    },

    mounted(){
        this.getData();
    },

    methods: {
        getData() {
            axios.get('/api/pekanbeasiswa')
            .then((response)=>{
                this.sesipb = response.data
            })
            .catch(({ response }) => {
                console.log(response)
            })
        },

        updateData(){

            const formData = new FormData()
            formData.append('nama', this.nama)
            formData.append('email', this.email)
            formData.append('sesi', this.sesi)
            formData.append('notes', this.notes)
            formData.append('_method', 'PUT');

            axios.post('/api/absensipekanbeasiswa', formData,{
                headers:{'Content-Type':'multipart/form-data'}
            })
            .then((response) => {

                if(response.data.id != null){
                    swal.fire({
                      icon:'success',
                      title:'Absensi peserta pekan beasiswa telah berhasil'
                    })
                    this.$router.go(0);
                }
                else{
                    swal.fire({
                      icon:'error',
                      title:response.data
                    })
                }

            })
            .catch(( response ) => {
               console.log(response);
               swal.fire({
                    icon: 'error',
                    title: 'Terdapat kesalahan',
                    text: response,
                });
            })
        },
    },
};

</script>

