<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3>
                        Data Donation
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminDonationTable" v-if="donations">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama Donator</th>
                                <th scope="col">No HP / Email</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Jenis barang / jumlah donasi</th>
                                <th >Status Verifikasi</th>
                                <th >Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in donations" :key="index">
                                <td>{{ d.createdDate }} </td>
                                <td>{{ d.donator.name }}</td>
                                <td>{{ d.donator.phone }} / {{ d.donator.email }}</td>
                                <td>                                   
                                    <small class="badge badge-success" v-if="d.category==1">Uang</small>
                                    <small class="badge badge-warning" v-else>Barang</small>
                                </td>
                                <td>{{ d.jenis_barang_or_jumlah_bayar }}</td>
                                <td>                                   
                                    <small class="badge badge-success" v-if="d.verification==1">Benar</small>
                                    <small class="badge badge-danger" v-else-if="d.verification==2">Salah</small>
                                    <small class="badge badge-warning" v-else>Belum</small>
                                </td>
                                <td>
                                    <router-link :to="{ name: 'admindonation.show', params: { id: d.id } }"  class="btn btn-sm btn-link">
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
        donations:{},
      }
    },

    computed: {
        endpoint() {
            return `/api/admindonation`;
        },
    },

    mounted(){
        axios.get(this.endpoint, {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        })
        .then((response)=>{
            this.donations = response.data;
            this.$nextTick(function() {
                $('#adminDonationTable').DataTable();
            })
        })
    },

    methods: {
        
    },  
};

</script>
