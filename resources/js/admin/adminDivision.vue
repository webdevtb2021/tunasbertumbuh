<template>
<div>
  <Navbar/>
<!-- Content -->
<section>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Data Departemen dan Divisi</h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                          <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click.prevent="showModal"><i class="fas fa-calendar-plus"></i> Add new data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminDivisionTable" v-if="data">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Struktur Di atasnya</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Tugas</th>
                                <th >Detail</th>
                                <th >Edit</th>
                                <th >Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in data.divisions" :key="index">
                                <td>{{ d.name }}</td>
                                <td v-if="d.parent != null">
                                    {{ d.parent.name }}
                                </td>
                                <td v-else> -
                                </td>
                                <td>{{ d.excerptDesc }}</td>
                                <td>
                                    {{ d.excerptTask }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-link" @click.prevent="detailData(d)">
                                        <i class="fas fa-info-circle text-success"/>
                                    </button>
                                </td>
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
                    <h5 v-show="formMode == 1" class="modal-title" id="exampleModalLabel">Detail data departemen/divisi</h5>
                    <h5 v-show="formMode == 2" class="modal-title" id="exampleModalLabel">Add new data departemen/divisi</h5>
                    <h5 v-show="formMode == 3" class="modal-title" id="exampleModalLabel">Update data departemen/divisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <!-- Form for adding/updating user details. When submitted call /createData() function if /isFormCreateMode value is true. Otherwise call /updateData() function. -->
                  <form @submit.prevent="formMode == 2 ? createData() : updateData()">
                    <div class="modal-body">
                        <div class="form-group">
                          <label>Name</label>
                          <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Nama Departemen/Divisi" aria-label="name" aria-describedby="basic-addon1" :disabled="isDisable"/>
                        </div>
                        <div class="form-group">
                          <label>Struktur Di atasnya</label>
                          <select class='form-control' v-model='form.parent_id'  :disabled="isDisable">
                                <option v-for='p in data.parents' :value='p.id'>{{ p.name }}</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Deskripsi</label>
                          <textarea v-model="form.description" type="text" name="description" class="form-control" placeholder="Keterangan" aria-label="keterangan" aria-describedby="basic-addon1"  :disabled="isDisable" :rows="isDisable ? 15 : 10 "/>
                        </div>
                        <div class="form-group">
                          <label>Tugas-Tugas</label>
                          <textarea v-model="form.task" type="text" name="task" class="form-control" placeholder="Tugas-tugas" aria-label="tugas" aria-describedby="basic-addon1"  :disabled="isDisable" :rows="isDisable ? 15 : 10 "/>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" v-show="formMode == 2">Save changes</button>
                      <button type="submit" class="btn btn-primary"  v-show="formMode == 3"> Update</button>
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
          name: '',
          description: '',
          task: '',
          parent:{
            id:'',
            name:''
          }
        }),
        //1:details, 2:create, 3:update
        formMode: 1,
        isDisable:true
      }
    },

    computed: {
        endpoint() {
            return `/api/admindivision`;
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
                $('#adminDivisionTable').DataTable();
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
                    $('#adminDivisionTable').DataTable();
                })
            })
        },

        detailData(d){
            this.formMode=1;
            this.isDisable=true;
            this.form.reset();
            this.form.clear();
            $('#exampleModal').modal('show'); 
            this.form.fill(d);
        },

        showModal() {
            this.formMode = 2;
            this.isDisable=false;
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
                    title:'Data division created successfully'
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

        editData(d){
            this.formMode=3;
            this.isDisable=false;
            this.form.reset();
            this.form.clear();
            $('#exampleModal').modal('show'); 
            this.form.fill(d);
        },

        updateData(){
            this.form.put(this.endpoint + '/' + this.form.id, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(()=>{
                $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data division updated successfully'
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
