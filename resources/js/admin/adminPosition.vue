<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Detail Data Member</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped"  v-if="data.member">
                      <tbody>
                        <tr>
                          <th>Nama</th>
                          <td>{{data.member.name}}</td>
                        </tr>
                        <tr>
                          <th>Email</th>
                          <td>{{data.member.email}}</td>
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
                            <td v-if="data.member.permission==0">Tidak memiliki Hak Akses admin</td>
                                <td v-else-if="data.member.permission==1">Founder / Executive Director</td>
                                <td v-else-if="data.member.permission==2">Admin AFD</td>
                                <td v-else-if="data.member.permission==3">Admin HRD</td>
                                <td v-else-if="data.member.permission==4">Admin MFD</td>
                                <td v-else-if="data.member.permission==5">Admin CPD</td>
                                <td v-else-if="data.member.permission==6">Admin PMD</td>
                                <td v-else-if="data.member.permission==7">Admin MIT</td>
                                <td v-else>Web Development</td>
                        </tr>
                        <tr>
                          <th>No telepon / wa</th>
                            <td v-if="data.member.latest_dependences">{{ data.member.latest_dependences.phone }}</td>
                            <td v-else></td>
                        </tr>
                        <tr>
                          <th>Instagram</th>
                          <td v-if="data.member.latest_dependences"><a :href="data.member.latest_dependences.instagram">{{data.member.latest_dependences.instagram}}</a></td>
                          <td v-else></td>
                        </tr>
                        <tr>
                          <th>Facebook</th>
                          <td v-if="data.member.latest_dependences"><a :href="data.member.latest_dependences.facebook">{{data.member.latest_dependences.facebook}}</a></td>
                          <td v-else></td>
                        </tr>
                        <tr>
                          <th>Url Twitter</th>
                          <td v-if="data.member.latest_dependences"><a :href="data.member.latest_dependences.twitter">{{data.member.latest_dependences.twitter}}</a></td>
                          <td v-else></td>
                        </tr>
                        <tr>
                          <th>Testimoni</th>
                            <td v-if="data.member.latest_dependences">{{ data.member.latest_dependences.testimony }}</td>
                            <td v-else></td>
                        </tr>
                        <tr>
                        <th>Riwayat Jabatan </th>
                            <td><button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click.prevent="showModal" v-if="auth_permission==3"><i class="fas fa-calendar-plus"></i> Tambahkan jabatan</button></td>
                        </tr>
                      </tbody>
                    </table>

                    <div class="card">
                        <div class="card-body">
                            <table class="table w-90" id="adminPositionTable" v-if="data.member">
                                <thead>
                                    <tr>
                                        <th scope="col">Periode</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Divisi</th>
                                        <th scope="col">Ketua</th>
                                        <th v-if="auth_permission==3">Edit</th>
                                        <th v-if="auth_permission==3">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(d, index) in data.member.positions" :key="index">
                                        <td>{{ d.periode.name }}</td>
                                        <td>{{ d.jabatan.name }}</td>
                                        <td>{{ d.division.name }}</td>
                                        <td>{{ d.leader.name }}</td>                                
                                        <td v-if="auth_permission==3">
                                            <button class="btn btn-sm btn-link" @click.prevent="editData(d)">
                                                <i class="fas fa-edit text-warning"/>
                                            </button>
                                        </td>
                                        <td v-if="auth_permission==3">
                                            <button class="btn btn-sm btn-link" @click.prevent="deleteData(d.id)">
                                                <i class="fas fa-trash  text-danger"/>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal containing dynamic form for adding/updating data details. -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <!-- Show/hide headings dynamically based on /isFormCreateMode value (true/false) -->
                    <h5 v-show="isFormCreateMode" class="modal-title" id="exampleModalLabel">Add new data</h5>
                    <h5 v-show="!isFormCreateMode" class="modal-title" id="exampleModalLabel">Update data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <!-- Form for adding/updating user details. When submitted call /createData() function if /isFormCreateMode value is true. Otherwise call /updateData() function. -->
                  <form @submit.prevent="isFormCreateMode ? createData() : updateData()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Periode</label>
                            <select class='form-control' v-model='form.periode_id' required>
                                <option v-for='p in data.period' :value='p.id'>{{ p.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class='form-control' v-model='form.jabatan_id' required>
                                <option v-for='p in data.jabatan' :value='p.id'>{{ p.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Divisi / Departemen</label>
                            <select class='form-control' v-model='form.division_id' required>
                                <option v-for='p in data.division' :value='p.id'>{{ p.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ketua / Leader</label>
                            <select class='form-control' v-model='form.leader' required>
                                <option v-for='p in data.leader' :value='p.id'>{{ p.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" v-show="isFormCreateMode">Save</button>
                      <button type="submit" class="btn btn-primary" v-show="!isFormCreateMode">Update</button>
                    </div>
                  </form>
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
import Navbar from '../components/Navbar';
export default {
    components: {
    Navbar,
     },
    props:['id'],
    data() {
      return {
        data:{},
        form: new Form({
          id:'',
          user_id:'',
          jabatan_id: '',
          periode_id: '',
          division_id: '',
          leader:'',
        }),
      }
    },

    computed: {
        endpoint() {
            return `/api/adminmember/${this.id}`;
        },
        positionroute() {
            return `/api/adminmember/${this.id}/adminposition`;
        },
        auth_id(){
            return localStorage.getItem('user_id');
        },
        auth_permission(){
            return localStorage.getItem("user_permission");
        },
    },

    mounted(){
        axios.get(this.endpoint, {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        })
        .then((response)=>{
            this.data = response.data;
            this.$nextTick(function() {
                $('#adminPositionTable').DataTable({"bLengthChange": false,"searching": false,});
            })
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
                this.data = response.data;
                this.$nextTick(function() {
                    $('#adminPositionTable').DataTable();
                });
            });
        },

        showModal() {
            this.isFormCreateMode = true;
            this.form.reset(); // v form reset
            $('#exampleModal').modal('show'); 
        },

        createData(){        
            this.form.user_id = this.id;
            this.form.post(this.positionroute, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(()=>{
                $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data keuangan created successfully'
                })
                this.getData();
            }).catch(()=>{
                console.log('submit failed');
            });
        },

        editData(d){
            this.isFormCreateMode=false;
            this.form.reset();
            this.form.clear();
            $('#exampleModal').modal('show'); 
            this.form.fill(d);
        },

        updateData(){
            this.form.user_id = this.id;
            this.form.put(this.positionroute + '/' + this.form.id, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(()=>{
                $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data keuangan updated successfully'
                })
                this.getData();
            }).catch(()=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please contact web development team for details'
                });
            });
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
                    this.form.delete(this.positionroute + '/' + id, {
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
    },
};

</script>
