<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3>
                        Daftar Peserta Pekan Beasiswa
                    </h3>
                    <div class="card-tools ml-auto col-4 d-flex align-items-center">
                        <Multiselect
                            v-model="sesi"
                            mode="multiple"
                            :close-on-select="true"
                            :searchable="true"
                            :create-option="true"
                            :options="sesipb"
                            placeholder="Pilih sesi di sini (All)"
                            key="sesipb"
                        /> 
                        &nbsp;
                        <button class="btn btn-sm btn-success" @click.prevent="getData()">
                            Search
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminPesertapbTable" v-if="pesertapbs">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Email</th>
                                <th scope="col">No WA</th>
                                <th scope="col">Instansi</th>
                                <th scope="col">Sesi</th>
                                <th scope="col">Sumber Informasi</th>
                                <th >Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in pesertapbs" :key="pesertapbs">
                                <td>{{ d.Nama }}</td>
                                <td>
                                    <p v-if="d.gender==1">Laki-laki</p>
                                    <p v-else>Perempuan</p>
                                </td>
                                <td>{{ d.email }}</td>
                                <td>{{ d.phone }}</td>
                                <td>{{ d.instansi }}</td>
                                <td><p v-for="sesi in d.sesipesertapbs">
                                      {{ sesi.sesipb.name }}, {{ sesi.sesipb.detail_waktu }}
                                      <br> 
                                      <small class="badge badge-success" v-if="sesi.waktu_absen !=null">Telah absen pada {{sesi.waktu_absen}}</small>
                                      <small class="badge badge-danger" v-else>Belum Absen</small></p></td>
                                <td>
                                    <p v-if="d.info==1">Teman</p>
                                    <p v-if="d.info==2">Instagram Tunas Bertumbuh</p>
                                    <p v-if="d.info==3">Facebook Tunas Bertumbuh</p>
                                    <p v-if="d.info==4">LinkedIn Tunas Bertumbuh</p>
                                    <p v-if="d.info==5">Media Partner Tunas Bertumbuh</p>
                                    <p v-if="d.info==6">Website Tunas Bertumbuh</p>
                                    <p v-if="d.info==7">Lainnya</p>
                                </td>
                                <td>
                                    <router-link :to="{ name: 'adminpesertapb.show', params: { id: d.id } }"  class="btn btn-sm btn-link">
                                        <i class="fas fa-info-circle text-success"/> 
                                    </router-link>
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

import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import "datatables.net-buttons-dt/css/buttons.dataTables.min.css"


import jsZip from 'jszip';

import "datatables.net-buttons/js/dataTables.buttons.js"
import "datatables.net-buttons/js/buttons.colVis.js"
import "datatables.net-buttons/js/buttons.flash.js"
import "datatables.net-buttons/js/buttons.html5.js"
import "datatables.net-buttons/js/buttons.print.js"

import $ from 'jquery'; 
import Multiselect from '@vueform/multiselect'

window.JSZip = jsZip;
import Navbar from '../components/Navbar';
export default {
    components: {
    Navbar,
    Multiselect,
    },

    data() {
      return {
        pesertapbs:{},
        sesipb:[],    
        sesi:[],
      }
    },

    computed: {
        endpoint() {
            return `/api/adminpesertapb`;
        },
    },

    mounted(){
        axios.get(this.endpoint, {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        })
        .then((response)=>{
            this.pesertapbs = response.data.pesertapbs;
            let sesipbs = response.data.sesipbs;
            this.sesipb = []
            this.$nextTick(function() {
                for(let i = 0; i < sesipbs.length; i++){
                  this.sesipb.push(
                      {value: sesipbs[i].id, 
                        label: sesipbs[i].name +", "+sesipbs[i].detail_waktu 
                      })
                }
                setTimeout(function(){
                    var table = $('#adminPesertapbTable').DataTable(
                        {
                            pagingType: 'full_numbers',
                            pageLength: 5,
                            processing: true,
                            dom: 'Bfrtip',
                            buttons: ['copyHtml5', 'excelHtml5', 'print']
                        }
                    );    
                    table.buttons().container().appendTo( '#example_wrapper .col-sm-6:eq(0)' );
                },1000);
            })
        })
    },

    methods: {
        getData(){
            if(this.sesi.length==0){
                $('#adminPesertapbTable').DataTable().destroy();
                axios.get(this.endpoint, {
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then((response)=>{
                        this.pesertapbs = response.data.pesertapbs;
                        this.$nextTick(function() {
                            
                            setTimeout(function(){
                                var table = $('#adminPesertapbTable').DataTable(
                                    {
                                        pagingType: 'full_numbers',
                                        pageLength: 5,
                                        processing: true,
                                        dom: 'Bfrtip',
                                        buttons: ['copyHtml5', 'excelHtml5', 'print']
                                    }
                                );    
                                table.buttons().container().appendTo( '#example_wrapper .col-sm-6:eq(0)' );
                            },1000);
                        })
                })
            }
            else{
                $('#adminPesertapbTable').DataTable().destroy();
                axios.get(this.endpoint+'s/'+this.sesi.toString(), {
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then((response)=>{
                        this.pesertapbs = response.data;
                        this.$nextTick(function() {
                            
                            setTimeout(function(){
                                var table = $('#adminPesertapbTable').DataTable(
                                    {
                                        pagingType: 'full_numbers',
                                        pageLength: 20,
                                        processing: true,
                                        dom: 'Bfrtip',
                                        buttons: ['copyHtml5', 'excelHtml5', 'print']
                                    }
                                );    
                                table.buttons().container().appendTo( '#example_wrapper .col-sm-6:eq(0)' );
                            },1000);
                        })
                        
                })
            }
        },
    },  
};

</script>
