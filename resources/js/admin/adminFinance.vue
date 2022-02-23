<template>
<div>
  <Navbar/>
<!-- Content -->
<section id="finance-report">
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Data Keuangan</h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                          <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click.prevent="showModal"><i class="fas fa-calendar-plus"></i> Add new data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminFinanceTable" v-if="data">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Pemasukan</th>
                                <th scope="col">Sumber Pemasukan</th>
                                <th scope="col">Pengeluaran</th>
                                <th scope="col">Saldo</th>
                                <th ></th>
                                <th ></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in data" :key="index">
                                <td>{{ d.date }}</td>
                                <td>
                                    {{ d.notes }}
                                </td>
                                <td>{{ d.debit }}</td>
                                <td>
                                    {{ d.source }}
                                </td>
                                <td>{{ d.kredit }}</td>
                                <td>{{ d.saldo }}</td>
                                <td>
                                    <button class="btn btn-sm btn-link" @click.prevent="editData(d)">
                                        <i class="fas fa-edit text-warning"/>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-link" @click.prevent="deleteData(d.id)">
                                        <i class="fas fa-trash  text-danger"/>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal containing dynamic form for adding/updating data details. -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <!-- Show/hide headings dynamically based on /isFormCreateMode value (true/false) -->
                    <h5 v-show="isFormCreateMode" class="modal-title" id="exampleModalLabel">Add new data keuangan</h5>
                    <h5 v-show="!isFormCreateMode" class="modal-title" id="exampleModalLabel">Update data keuangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <!-- Form for adding/updating user details. When submitted call /createData() function if /isFormCreateMode value is true. Otherwise call /updateData() function. -->
                  <form @submit.prevent="isFormCreateMode ? createData() : updateData()">
                    <div class="modal-body">
                        <div class="form-group">
                          <label>Tanggal</label>
                          <input v-model="form.date" type="text" name="date" class="form-control" placeholder="dd-mm-yyyy" aria-label="tanggal" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                          <label>Keterangan</label>
                          <textarea v-model="form.notes" type="text" name="notes" class="form-control" placeholder="Keterangan" aria-label="keterangan" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                          <label>Nominal Pemasukan</label>
                          <input v-model="form.debit" type="number" name="debit" class="form-control" placeholder="Rp 000.000" aria-label="pemasukan" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                          <label>Sumber Pemasukan</label>
                          <input v-model="form.source" type="text" name="source" class="form-control" placeholder="Sumber Pemasukan" aria-label="sumpemasukan" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                          <label>Nominal Pengeluaran</label>
                          <input v-model="form.kredit" type="number" name="kredit" class="form-control" placeholder="Rp 000.000" aria-label="kredit" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                          <label>Saldo</label>
                          <input v-model="form.saldo" type="number" name="saldo" class="form-control" placeholder="Rp 000.000" aria-label="saldo" aria-describedby="basic-addon1"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" v-show="isFormCreateMode">Save changes</button>
                      <button type="submit" class="btn btn-primary" v-show="!isFormCreateMode">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>  
        </div>
    </div>
</section>
<!-- ./Content -->
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
        data:{},
        form: new Form({
          id:'',
          date: '',
          notes: '',
          debit: '',
          source: '',
          kredit: '',
          saldo: ''
        }),
        isFormCreateMode: true
      }
    },

    computed: {
        endpoint() {
            return `/api/adminfinance`;
        },
    },

    mounted(){
        axios.get(this.endpoint, 
            {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            }
        )
        .then((response)=>{
            this.data = response.data;
            this.$nextTick(function() {
                $('#adminFinanceTable').DataTable();
            })
        })
    },

    methods: {
        getData() {
            axios.get(this.endpoint)
            .then((response)=>{
                this.data = response.data;
                this.$nextTick(function() {
                    $('#adminFinanceTable').DataTable();
                })
            })
        },

        showModal() {
            this.isFormCreateMode = true;
            this.form.reset(); // v form reset
            $('#exampleModal').modal('show'); 
        },

        createData(){
            this.form.post(this.endpoint, {
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
            console.log(this.form.id)
            this.form.put(this.endpoint + '/' + this.form.id, {
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
                    this.form.delete(this.endpoint + '/' + id, {
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
