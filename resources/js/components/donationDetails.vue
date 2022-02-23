<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Detail Data Donation</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped"  v-if="donations.donator">
                      <tbody>
                        <tr>
                          <th>Nama Donator</th>
                          <td>{{donations.donator.name}}</td>
                        </tr>
                        <tr>
                          <th>Email</th>
                          <td>{{donations.donator.email}}</td>
                        </tr>
                        <tr>
                          <th>No Telepon</th>
                          <td>{{donations.donator.phone}}</td>
                        </tr>
                        <tr>
                          <th>Alamat</th>
                          <td>{{donations.donator.address}}</td>
                        </tr>
                        <tr>
                          <th>Kategori Donasi</th>
                          <td v-if="donations.category==1">Uang</td>
                          <td v-else>Barang</td>
                        </tr>
                        <tr>
                          <th v-if="donations.category==1">Nominal</th>
                          <th v-else>Jenis Barang</th>
                          <td>{{donations.jenis_barang_or_jumlah_bayar}}</td>
                        </tr>
                        <tr>
                          <th>Bukti Transfer / Bukti Pengiriman</th>
                          <td>
                              <vue-picture-swipe :items="image"></vue-picture-swipe> 
                          </td>
                        </tr>
                        <tr>
                          <th>Keterangan</th>
                          <td>{{donations.notes}}</td>
                        </tr>                        
                        <tr>
                          <th>Status Verifikasi</th>
                          <td v-if="isNotChange">
                          	<small class="badge badge-success" v-if="donations.verification==1">Verifikasi Benar</small>
                            <small class="badge badge-danger" v-else-if="donations.verification==2"> Verifikasi Salah</small>
                            <small class="badge badge-warning" v-else>Belum Diverifikasi</small>
                            <button class="btn btn-sm btn-link" @click.prevent="changeVerification()">
                                <i class="fas fa-edit text-warning"/>
                            </button>
                          </td>
                          <td v-else>
                          	<select class="form-control" v-model="form.verification">
                                <option value="1">Verifikasi Benar</option>
                                <option value="2">Verifikasi Salah</option>
                                <option value="3">Belum Diverifikasi</option>
                            </select>
                          </td>
                        </tr>
                        <tr v-show="!isNotChange">
	                        <th></th>
	                        <td>
	                        	<form @submit.prevent="updateData()">
	                        		<button type="submit" class="btn btn-primary">Save Changes</button>
	                        	</form>
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
        donations:{},
        form: new Form({
          id:'',
          verification:'',
        }),
        isNotChange:true,
        image:ref([]),
      }
    },

    computed: {
        endpoint() {
            return `/api/admindonation/${this.id}`;
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
                this.image=ref([]);
                this.$nextTick(function() {
                    this.image.push(
                        {
                          src: '../storage/images/donations/'+this.donations.bukti,
                          thumbnail: '../storage/images/donations/'+this.donations.bukti,
                          w: 1200,
                          h: 900
                        }
                    );
                });
        })
    },

    methods: {
        getData() {
            axios.get(this.endpoint, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
	        .then((response)=>{
	            this.donations = response.data;
                this.image=ref([]);
                this.$nextTick(function() {
                    this.image.push(
                        {
                          src: '../storage/images/donations/'+this.donations.bukti,
                          thumbnail: '../storage/images/donations/'+this.donations.bukti,
                          w: 1200,
                          h: 900
                        }
                    );
                });
	        })
        },

        updateData(){
            this.form.put(this.endpoint, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(()=>{
                $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Verification updated successfully'
                })
                this.isNotChange = true;
                this.getData();
            }).catch(()=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please contact web development team for details'
                });
                this.isNotChange = true;
            });
        },

        changeVerification(){
        	this.form.id=this.id
        	this.form.verification = this.donations.verification
        	this.isNotChange = false
        },
    },
};

</script>
