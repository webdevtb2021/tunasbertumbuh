<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Detail Peserta Pekan Beasiswa</h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                            <router-link :to="{ name: 'AdminPesertapb' }" class="btn btn-success">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                      <tbody>
                            <tr>
                              <th class="col-5">Nama</th>
                              <td>{{data.Nama}}</td>
                            </tr>
                            <tr>
                              <th>Jenis Kelamin</th>
                              <td>
                                  <p v-if="data.gender==1">Laki-laki</p>
                                  <p v-else>Perempuan</p>
                              </td>
                            </tr>
                            <tr>
                              <th>Email</th>
                              <td>{{data.email}}</td>
                            </tr>
                            <tr>
                              <th>No WA</th>
                              <td>{{data.phone}}</td>
                            </tr>
                            <tr>
                              <th>Instansi</th>
                              <td>{{data.instansi}}</td>
                            </tr>
                            <tr>
                              <th>Sesi yang diikuti</th>
                              <td>
                                  <p v-for="sesi in data.sesipesertapbs">
                                      {{ sesi.sesipb.name }}, {{ sesi.sesipb.detail_waktu }} | 
                                      <small class="badge badge-success" v-if="sesi.waktu_absen !=null">Telah absen pada {{sesi.waktu_absen}}</small>
                                      <small class="badge badge-danger" v-else>Belum Absen</small>
                                      <br>
                                      <small> {{sesi.notes}}</small>
                                      <br>
                                      <br>
                                  </p>
                              </td>
                            </tr>
                            <tr>
                              <th>Sumber informasi</th>
                              <td>
                                  <p v-if="data.info==1">Teman</p>
                                  <p v-else-if="data.info==2">Instagram Tunas Bertumbuh</p>
                                  <p v-else-if="data.info==3">Facebook Tunas Bertumbuh</p>
                                  <p v-else-if="data.info==4">LinkedIn Tunas Bertumbuh</p>
                                  <p v-else-if="data.info==5">Media Partner Tunas Bertumbuh</p>
                                  <p v-else-if="data.info==6">Website Tunas Bertumbuh</p>
                                  <p v-else>Lainnya</p>
                              </td>
                            </tr>
                            <tr>
                              <th>Screenshot follow instagram Tunas Bertumbuh</th>
                              <td>
                                <vue-picture-swipe :items="ssfollow"></vue-picture-swipe>
                              </td>
                            </tr>
                            <tr>
                              <th>Screenshot like postingan instagram Pekan Beasiswa </th>
                              <td>
                                <vue-picture-swipe :items="sslikeig"></vue-picture-swipe>
                              </td>
                            </tr>
                            <tr>
                              <th>Screenshot like fanpage facebook Tunas Bertumbuh</th>
                              <td>
                                <vue-picture-swipe :items="sslikefb"></vue-picture-swipe>
                              </td>
                            </tr>
                      </tbody>
                    </table>
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
        data:{},  
        ssfollow : ref([]),
        sslikeig : ref([]),
        sslikefb : ref([]),
      }
    },

    computed: {
        endpoint() {
            return `/api/adminpesertapb/${this.id}`;
        },


    },

    mounted(){
      this.getData()
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
                this.ssfollow=ref([]);
                this.sslikeig=ref([]);
                this.sslikefb=ref([]);
                this.$nextTick(function() {
                    this.ssfollow.push(
                        {
                          src: '../storage/images/pekanbeasiswas/'+this.data.ssfollow,
                          thumbnail: '../storage/images/pekanbeasiswas/'+this.data.ssfollow,
                          w: 1200,
                          h: 900
                        }
                    );
                    this.sslikeig.push(
                        {
                          src: '../storage/images/pekanbeasiswas/'+this.data.sslikeig,
                          thumbnail: '../storage/images/pekanbeasiswas/'+this.data.sslikeig,
                          w: 1200,
                          h: 900
                        }
                    );
                    this.sslikefb.push(
                         {
                          src: '../storage/images/pekanbeasiswas/'+this.data.sslikefb,
                          thumbnail: '../storage/images/pekanbeasiswas/'+this.data.sslikefb,
                          w: 1200,
                          h: 900
                        }
                    );
                })
            })            
        },
    },
};

</script>

<style>
img[itemprop="thumbnail"] {
    width: 100px;
}
</style>
